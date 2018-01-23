<?php
namespace YouTrack;

/**
 * A class describing current youtrack user.
 *
 * @property string login
 * @method string getLogin
 * @method string setLogin(string $value)
 * @property string fullName
 * @method string getFullName
 * @method string setFullName(string $value)
 * @property string email
 * @method string getEmail
 * @method string setEmail(string $value)
 * @property string lastCreatedProject
 * @method string getLastCreatedProject
 * @method string setLastCreatedProject(string $value)
 *
 * @link https://www.jetbrains.com/help/youtrack/standalone/Get-Info-For-Current-User.html
 */
class CurrentUser extends BaseObject
{
}
