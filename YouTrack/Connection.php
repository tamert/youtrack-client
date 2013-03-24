<?php
namespace YouTrack;

spl_autoload_register(function ($className)
{
    if (class_exists($className)) {
        return true;
    }
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    require $fileName;
});

/**
 * A class for connecting to a youtrack instance.
 *
 * @internal revision
 * 20120318 - francisco.mancardi@gmail.com
 * new method get_global_issue_states()
 * Important Notice
 * REST API documentation for version 3.x this method is not documented.
 * REST API documentation for version 2.x this method is DOCUMENTED.
 * (http://confluence.jetbrains.net/display/YTD2/Get+Issue+States)
 *
 * new method get_state_bundle()
 *
 * @author Jens Jahnke <jan0sch@gmx.net>
 * Created at: 29.03.11 16:13
 */
class Connection
{
    private $http = null;
    private $url = '';
    private $base_url = '';
    private $headers = array();
    private $cookies = array();
    private $debug_verbose = false; // Set to TRUE to enable verbose logging of curl messages.
    private $user_agent = 'Mozilla/5.0'; // Use this as user agent string.
    private $verify_ssl = false;

    public function __construct($url, $login, $password)
    {
        $this->http = curl_init();
        $this->url = $url;
        $this->base_url = $url . '/rest';
        $this->login($login, $password);
    }

  /**
   * Loop through the given array and remove all entries
   * that have no value assigned.
   *
   * @param array &$params The array to inspect and clean up.
   */
  private function cleanUrlParameters(&$params)
  {
    if (!empty($params) && is_array($params)) {
      foreach ($params as $key => $value) {
        if (empty($value)) {
          unset($params["$key"]);
        }
      } // foreach
    }
  }

    protected function login($login, $password)
    {
        curl_setopt($this->http, CURLOPT_POST, true);
        curl_setopt($this->http, CURLOPT_HTTPHEADER, array('Content-Length: 1')); //Workaround for problems when after lighthttp proxy
        curl_setopt($this->http, CURLOPT_URL, $this->base_url . '/user/login?login='. urlencode($login) .'&password='. urlencode($password));
        curl_setopt($this->http, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->http, CURLOPT_HEADER, true);
        curl_setopt($this->http, CURLOPT_SSL_VERIFYPEER, $this->verify_ssl);
        curl_setopt($this->http, CURLOPT_USERAGENT, $this->user_agent);
        curl_setopt($this->http, CURLOPT_VERBOSE, $this->debug_verbose);
        curl_setopt($this->http,CURLOPT_POSTFIELDS,"a");
        $content = curl_exec($this->http);
        $response = curl_getinfo($this->http);
        if ((int) $response['http_code'] != 200) {
            throw new Exception('/user/login', $response, $content);
        }
        $cookies = array();
        preg_match_all('/^Set-Cookie: (.*?)=(.*?)$/sm', $content, $cookies, PREG_SET_ORDER);
        foreach($cookies as $cookie) {
            $parts = parse_url($cookie[0]);
            $this->cookies[] = $parts['path'];
        }
        $this->headers[CURLOPT_HTTPHEADER] = array('Cache-Control: no-cache');
        curl_close($this->http);
    }

  /**
   * Execute a request with the given parameters and return the response.
   *
   * @throws \Exception|Exception An exception is thrown if an error occurs.
   * @param string $method The http method (GET, PUT, POST).
   * @param string $url The request url.
   * @param string $body Data that should be send or the filename of the file if PUT is used.
   * @param int $ignore_status Ignore the given http status code.
   * @return array An array holding the response content in 'content' and the response status
   * in 'response'.
   */
  protected function request($method, $url, $body = null, $ignore_status = 0) {
    $this->http = curl_init($this->base_url . $url);
    $headers = $this->headers;
    if ($method == 'PUT' || $method == 'POST') {
      $headers[CURLOPT_HTTPHEADER][] = 'Content-Type: application/xml; charset=UTF-8';
      $headers[CURLOPT_HTTPHEADER][] = 'Content-Length: '. mb_strlen($body);
    }
    switch ($method) {
      case 'GET':
        curl_setopt($this->http, CURLOPT_HTTPGET, true);
        break;
      case 'PUT':
        $handle = null;
        $size = 0;
        // Check if we got a file or just a string of data.
        if (file_exists($body)) {
          $size = filesize($body);
          if (!$size) {
            throw new \Exception("Can't open file $body!");
          }
          $handle = fopen($body, 'r');
        }
        else {
          $size = mb_strlen($body);
          $handle = fopen('data://text/plain,' . $body,'r');
        }
        curl_setopt($this->http, CURLOPT_PUT, true);
        curl_setopt($this->http, CURLOPT_INFILE, $handle);
        curl_setopt($this->http, CURLOPT_INFILESIZE, $size);
        break;
      case 'POST':
        curl_setopt($this->http, CURLOPT_POST, true);
        if (!empty($body)) {
          curl_setopt($this->http, CURLOPT_POSTFIELDS, $body);
        }
        break;
      default:
        throw new \Exception("Unknown method $method!");
    }
    curl_setopt($this->http, CURLOPT_HTTPHEADER, $headers[CURLOPT_HTTPHEADER]);
    curl_setopt($this->http, CURLOPT_USERAGENT, $this->user_agent);
    curl_setopt($this->http, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($this->http, CURLOPT_SSL_VERIFYPEER, $this->verify_ssl);
    curl_setopt($this->http, CURLOPT_VERBOSE, $this->debug_verbose);
    curl_setopt($this->http, CURLOPT_COOKIE, implode(';', $this->cookies));
    $content = curl_exec($this->http);
    $response = curl_getinfo($this->http);
    curl_close($this->http);
    if ((int) $response['http_code'] != 200 && (int) $response['http_code'] != 201 && (int) $response['http_code'] != $ignore_status) {
      throw new Exception($url, $response, $content);
    }

    return array(
      'content' => $content,
      'response' => $response,
    );
  }

  protected function requestXml($method, $url, $body = null, $ignore_status = 0) {
    $r = $this->request($method, $url, $body, $ignore_status);
    $response = $r['response'];
    $content = $r['content'];
    if (!empty($response['content_type'])) {
      if (preg_match('/application\/xml/', $response['content_type']) || preg_match('/text\/xml/', $response['content_type'])) {
        return simplexml_load_string($content);
      }
    }
    return $content;
  }

  protected function get($url) {
    return $this->requestXml('GET', $url);
  }

  protected function put($url) {
    return $this->requestXml('PUT', $url, '<empty/>\n\n');
  }

  public function getIssue($id) {
    $issue = $this->get('/issue/' . $id);
    return new Issue($issue);
  }

    /**
     * creates an issue with properties from $params
     *
     * may be this is an general $params value:
     * <code>
     *  $params = array(
        'project' => (string)$project,
        'assignee' => (string)$assignee,
        'summary' => (string)$summary,
        'description' => (string)$description,
        'priority' => (string)$priority,
        'type' => (string)$type,
        'subsystem' => (string)$subsystem,
        'state' => (string)$state,
        'affectsVersion' => (string)$affectsVersion,
        'fixedVersion' => (string)$fixedVersion,
        'fixedInBuild' => (string)$fixedInBuild,
        );
     * </code>
     *
     * @param string $project the obligatory project name
     * @param string $summary the obligatory issue summary
     * @param array $params optional additional parameters for the new issue (look into your personal youtrack instance!)
     * @return Issue
     */
    public function createIssue($project, $summary, $params = []) {

    $params['project'] = (string)$project;
    $params['summary'] = (string)$summary;
    array_walk($params, function (&$value) {
      // php manual: If funcname needs to be working with the actual values of the array,
      //  specify the first parameter of funcname as a reference. Then, any changes made to
      //  those elements will be made in the original array itself.
      $value = (string)$value;
    });
    $issue = $this->requestXml('POST', '/issue?'. http_build_query($params));
    return new Issue($issue);
  }

  public function getAccessibleProjects() {
    $xml = $this->get('/project/all');
    $projects = array();

    foreach ($xml->children() as $node) {
      $node = new Project(new \SimpleXMLElement($node->asXML()));
      $projects[] = $node;
    }
    return $projects;
  }

  public function getComments($id) {
    $comments = array();
    $req = $this->request('GET', '/issue/'. urlencode($id) .'/comment');
    $xml = simplexml_load_string($req['content']);
    foreach($xml->children() as $node) {
      $comments[] = new Comment($node);
    }
    return $comments;
  }

  public function getAttachments($id) {
    $attachments = array();
    $req = $this->request('GET', '/issue/'. urlencode($id) .'/attachment');
    $xml = simplexml_load_string($req['content']);
    foreach($xml->children() as $node) {
      $attachments[] = new Comment($node);
    }
    return $attachments;
  }

  public function getAttachmentContent($url) {
    //TODO Switch to curl for better error handling.
    $file = file_get_contents($url);
    if ($file === false) {
      throw new \Exception("An error occured while trying to retrieve the following file: $url");
    }
    return $file;
  }

    /**
     * @param $issue_id
     * @param Attachment $attachment
     * @throws NotImplementedException
     */
    public function createAttachmentFromAttachment($issue_id, Attachment $attachment)
    {
        throw new NotImplementedException("create_attachment_from_attachment(issue_id, attachment)");
    }

  public function createAttachment($issue_id, $name, $content, $author_login = '', $content_type = null, $content_length = null, $created = null, $group = '') {
    throw new NotImplementedException("create_attachment(issue_id, name, content, ...)");
  }

  public function getLinks($id , $outward_only = false) {
    $links = array();
    $req = $this->request('GET', '/issue/'. urlencode($id) .'/link');
    $xml = simplexml_load_string($req['content']);
    foreach($xml->children() as $node) {
      if (($node->attributes()->source != $id) || !$outward_only) {
        $links[] = new Link($node);
      }
    }
    return $links;
  }

  public function getUser($login) {
    return new User($this->get('/admin/user/'. urlencode($login)));
  }

  public function createUser($user) {
    $this->importUsers(array($user));
  }

  public function createUserDetailed($login, $full_name, $email, $jabber) {
    $this->importUsers(array(array('login' => $login, 'fullName' => $full_name, 'email' => $email, 'jabber' => $jabber)));
  }

  public function importUsers($users) {
    if (count($users) <= 0) {
      return;
    }
    $xml = "<list>\n";
    foreach ($users as $user) {
      $xml .= "  <user";
      foreach ($user as $key => $value) {
        $xml .= " $key=". urlencode($value);
      }
      $xml .= " />\n";
    }
    $xml .= "</list>";
    return $this->requestXml('PUT', '/import/users', $xml, 400);
  }

  public function importIssuesXml($project_id, $assignee_group, $xml) {
    throw new NotImplementedException("import_issues_xml(project_id, assignee_group, xml)");
  }

  public function importLinks($links) {
    throw new NotImplementedException("import_links(links)");
  }

  public function importIssues($project_id, $assignee_group, $issues) {
    throw new NotImplementedException("import_issues(project_id, assignee_group, issues)");
  }

  public function getProject($project_id) {
    return new Project($this->get('/admin/project/'. urlencode($project_id)));
  }

  public function getProjectAssigneeGroups($project_id) {
    $xml = $this->get('/admin/project/'. urlencode($project_id) .'/assignee/group');
    $groups = array();
    foreach ($xml->children() as $group) {
      $groups[] = new Group(new \SimpleXMLElement($group->asXML()));
    }
    return $groups;
  }

  public function getGroup($name) {
    return new Group($this->get('/admin/group/'. urlencode($name)));
  }

  public function getUserGroups($login) {
    $xml = $this->get('/admin/user/'. urlencode($login) .'/group');
    $groups = array();
    foreach ($xml->children() as $group) {
      $groups[] = new Group(new \SimpleXMLElement($group->asXML()));
    }
    return $groups;
  }

  public function setUserGroup($login, $group_name) {
    $r = $this->request('POST', '/admin/user/'. urlencode($login) .'/group/'. urlencode($group_name));
    return $r['response'];
  }

  public function createGroup(Group $group) {
    $r = $this->put('/admin/group/'. urlencode($group->name) .'?description=noDescription&autoJoin=false');
    return $r['response'];
  }

  public function getRole($name) {
    return new Role($this->get('/admin/role/'. urlencode($name)));
  }

  public function getSubsystem($project_id, $name) {
    return new Subsystem($this->get('/admin/project/'. urlencode($project_id) .'/subsystem/'. urlencode($name)));
  }

  public function getSubsystems($project_id) {
    $xml = $this->get('/admin/project/'. urlencode($project_id) .'/subsystem');
    $subsystems = array();
    foreach ($xml->children() as $subsystem) {
      $subsystems[] = new Subsystem(new \SimpleXMLElement($subsystem->asXML()));
    }
    return $subsystems;
  }

  public function getVersions($project_id) {
    $xml = $this->get('/admin/project/'. urlencode($project_id) .'/version?showReleased=true');
    $versions = array();
    foreach ($xml->children() as $version) {
      $versions[] = new Version(new \SimpleXMLElement($version->asXML()));
    }
    return $versions;
  }

  public function getVersion($project_id, $name) {
    return new Version($this->get('/admin/project/'. urlencode($project_id) .'/version/'. urlencode($name)));
  }

  public function getBuilds($project_id) {
    $xml = $this->get('/admin/project/'. urlencode($project_id) .'/build');
    $builds = array();
    foreach ($xml->children() as $build) {
      $builds[] = new Build(new \SimpleXMLElement($build->asXML()));
    }
    return $builds;
  }

  public function getUsers($q = '') {
    $users = array();
    $q = trim((string)$q);
    $params = array(
      'q' => $q,
    );
    $this->cleanUrlParameters($params);
    $xml = $this->get('/admin/user/?'. http_build_query($params));
    if (!empty($xml) && is_object($xml)) {
      foreach ($xml->children() as $user) {
        $users[] = new User(new \SimpleXMLElement($user->asXML()));
      }
    }
    return $users;
  }

  public function createBuild() {
    throw new NotImplementedException("create_build()");
  }

  public function createBuilds() {
    throw new NotImplementedException("create_builds()");
  }

  public function createProject($project)
  {
    return $this->createProjectDetailed($project->id, $project->name, $project->description, $project->leader);
  }

  public function createProjectDetailed($project_id, $project_name, $project_description, $project_lead_login, $starting_number = 1) {
    $params = array(
      'projectName' => (string)$project_name,
      'description' => (string)$project_description,
      'projectLeadLogin' => (string)$project_lead_login,
      'lead' => (string)$project_lead_login,
      'startingNumber' => (string)$starting_number,
    );
    return $this->put('/admin/project/'. urlencode($project_id) .'?'. http_build_query($params));
  }

  public function createSubsystems($project_id, $subsystems) {
    foreach ($subsystems as $subsystem) {
      $this->createSubsystem($project_id, $subsystem);
    }
  }

  public function createSubsystem($project_id, $subsystem) {
    return $this->createSubsystemDetailed($project_id, $subsystem->name, $subsystem->isDefault, $subsystem->defaultAssignee);
  }

  public function createSubsystemDetailed($project_id, $name, $is_default, $default_assignee_login) {
    $params = array(
      'isDefault' => (string)$is_default,
      'defaultAssignee' => (string)$default_assignee_login,
    );
    $this->put('/admin/project/'. urlencode($project_id). '/subsystem/'. urlencode($name) .'?'. http_build_query($params));
    return 'Created';
  }

  public function deleteSubsystem($project_id, $name) {
    return $this->requestXml('DELETE', '/admin/project/'. urlencode($project_id) .'/subsystem/'. urlencode($name));
  }

  public function createVersions($project_id, $versions) {
    foreach ($versions as $version) {
      $this->createVersion($project_id, $version);
    }
  }

  public function createVersion($project_id, $version) {
    return $this->createVersionDetailed($project_id, $version->name, $version->isReleased, $version->isArchived, $version->releaseDate, $version->description);
  }

  public function createVersionDetailed($project_id, $name, $is_released, $is_archived, $release_date = null, $description = '') {
    $params = array(
      'description' => (string)$description,
      'isReleased' => (string)$is_released,
      'isArchived' => (string)$is_archived,
    );
    if (!empty($release_date)) {
      $params['releaseDate'] = $release_date;
    }
    return $this->put('/admin/project/'. urldecode($project_id) .'/version/'. urlencode($name) .'?'. http_build_query($params));
  }

  public function getIssues($project_id, $filter, $after, $max) {
    $params = array(
      'after' => (string)$after,
      'max' => (string)$max,
      'filter' => (string)$filter,
    );
    $this->cleanUrlParameters($params);
    $xml = $this->get('/project/issues/'. urldecode($project_id) .'?'. http_build_query($params));
    $issues = array();
    foreach ($xml->children() as $issue) {
      $issues[] = new Issue(new \SimpleXMLElement($issue->asXML()));
    }
    return $issues;
  }

  public function executeCommand($issue_id, $command, $comment = null, $group = null) {
    $params = array(
      'command' => (string)$command,
    );
    if (!empty($comment)) {
      $params['comment'] = (string)$comment;
    }
    if (!empty($group)) {
      $params['group'] = (string)$group;
    }
    $r = $this->request('POST', '/issue/'. urlencode($issue_id) .'/execute?'. http_build_query($params));
    return 'Command executed';
  }

  public function getCustomField($name) {
    return new CustomField($this->get('/admin/customfield/field/'. urlencode($name)));
  }

  public function getCustomFields() {
    $xml = $this->get('/admin/customfield/field');
    $fields = array();
    foreach ($xml->children() as $field) {
      $fields[] = new CustomField(new \SimpleXMLElement($field->asXML()));
    }
    return $fields;
  }

  public function createCustomFields($fields) {
    foreach ($fields as $field) {
      $this->createCustomField($field);
    }
  }

  public function createCustomField($field) {
    return $this->createCustomFieldDetailed($field->name, $field->type, $field->isPrivate, $field->visibleByDefault);
  }

  public function createCustomFieldDetailed($name, $type_name, $is_private, $default_visibility) {
    $params = array(
      'typeName' => (string)$type_name,
      'isPrivate' => (string)$is_private,
      'defaultVisibility' => (string)$default_visibility,
    );
    $this->put('/admin/customfield/field/'. urlencode($name) .'?'. http_build_query($params));
    return 'Created';
  }

  public function getEnumBundle($name) {
    return new EnumBundle($this->get('/admin/customfield/bundle/'. urlencode($name)));
  }

  public function createEnumBundle(EnumBundle $bundle) {
    return $this->requestXml('PUT', '/admin/customfield/bundle', $bundle->toXML(), 400);
  }

  public function deleteEnumBundle($name) {
    $r = $this->request('DELETE', '/admin/customfield/bundle/'. urlencode($name), '');
    return $r['content'];
  }

  public function addValueToEnumBundle($name, $value) {
    return $this->put('/admin/customfield/bundle/'. urlencode($name) .'/'. urlencode($value));
  }

  public function addValuesToEnumBundle($name, $values) {
    foreach ($values as $value) {
      $this->addValueToEnumBundle($name, $value);
    }
    return implode(', ', $values);
  }

  public function getProjectCustomField($project_id, $name) {
    return new CustomField($this->get('/admin/project/'. urlencode($project_id) .'/customfield/'. urlencode($name)));
  }

  public function getProjectCustomFields($project_id) {
    $xml = $this->get('/admin/project/'. urlencode($project_id) .'/customfield');
    $fields = array();
    foreach ($xml->children() as $cfield) {
      $fields[] = new CustomField(new \SimpleXMLElement($cfield->asXML()));
    }
    return $fields;
  }

  public function createProjectCustomField($project_id, CustomField $pcf) {
    return $this->createProjectCustomFieldDetailed($project_id, $pcf->name, $pcf->emptyText, $pcf->params);
  }

  private function createProjectCustomFieldDetailed($project_id, $name, $empty_field_text, $params = array()) {
    $_params = array(
      'emptyFieldText' => (string)$empty_field_text,
    );
    if (!empty($params)) {
      $_params = array_merge($_params, $params);
    }
    return $this->put('/admin/project/'. urlencode($project_id) .'/customfield/'. urlencode($name) .'?'. http_build_query($_params));
  }

  public function getIssueLinkTypes() {
    $xml = $this->get('/admin/issueLinkType');
    $lts = array();
    foreach ($xml->children() as $node) {
      $lts[] = new IssueLinkType(new \SimpleXMLElement($node->asXML()));
    }
    return $lts;
  }

  public function createIssueLinkTypes($lts) {
    foreach ($lts as $lt) {
      $this->createIssueLinkType($lt);
    }
  }

  public function createIssueLinkType($ilt) {
    return $this->createIssueLinkTypeDetailed($ilt->name, $ilt->outwardName, $ilt->inwardName, $ilt->directed);
  }

  public function createIssueLinkTypeDetailed($name, $outward_name, $inward_name, $directed) {
    $params = array(
      'outwardName' => (string)$outward_name,
      'inwardName' => (string)$inward_name,
      'directed' => (string)$directed,
    );
    return $this->put('/admin/issueLinkType/'. urlencode($name) .'?'. http_build_query($params));
  }

  public function getVerifySsl() {
    return $this->verify_ssl;
  }

  /**
   * Use this method to enable or disable the ssl_verifypeer option of curl.
   * This is usefull if you use self-signed ssl certificates.
   *
   * @param bool $verify_ssl
   * @return void
   */
  public function setVerifySsl($verify_ssl) {
    $this->verify_ssl = $verify_ssl;
  }

  /**
   * get pairs (state,revolved attribute) in hash.
   * same info is get online on: 
   * Project Fields › States (Click to change bundle name) 
   * 
   * @return hash key: state string 
   *              value: true is resolved attribute set to true	
   */
  public function getGlobalIssueStates() {
    $xml = $this->get('/project/states');
	$states = null;
    foreach($xml->children() as $node) {
      $states[(string)$node['name']] = ((string)$node['resolved'] == 'true');
    }
    return $states;
  }

  /**
   * useful when you have configured different states for different projects
   * in this cases you will create bundles with name with global scope,
   * i.e. name can not be repeated on youtrack installation.
   *
   * @param string $name
   * @return hash key: state string
   *			  value: hash('description' => string, 'isResolved' => boolean) 
   */
  public function getStateBundle($name) {

	$cmd = '/admin/customfield/stateBundle/' . urlencode($name);
    $xml = $this->get($cmd);
	$bundle = null;
    foreach($xml->children() as $node) {
       $bundle[(string)$node] = array('description' => (isset($node['description']) ? (string)$node['description'] : ''),
      								 'isResolved' => ((string)$node['isResolved']=='true'));
    }
    return $bundle;
  }
}
