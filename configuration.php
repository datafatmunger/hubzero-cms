<?php
class JConfig {
	var $offline = '0';
	var $editor = 'none';
	var $list_limit = '20';
	var $helpurl = 'http://help.joomla.org';
	var $debug = '0';
	var $debug_lang = '0';
	var $sef = '1';
	var $sef_rewrite = '1';
	var $sef_suffix = '0';
	var $feed_limit = '20';
	var $feed_email = 'author';
	var $secret = '8rceHwSz4vuDNXhX';
	var $gzip = '0';
	var $error_reporting = '-1';
	var $xmlrpc_server = '1';
	var $log_path = '/var/logs';
	var $tmp_path = '/tmp';
	var $live_site = '';
	var $force_ssl = '0';
	var $offset = '0';
	var $caching = '0';
	var $cachetime = '5';
	var $cache_handler = 'file';
	var $memcache_settings = array();
	var $ftp_enable = '0';
	var $ftp_host = '';
	var $ftp_port = '0';
	var $ftp_user = '';
	var $ftp_pass = '';
	var $ftp_root = '';
	var $dbtype = 'mysql';
	var $host = 'localhost';
	var $user = 'neeshub';
	var $db = 'neeshub';
	var $dbprefix = 'jos_';
	var $mailer = 'mail';
	var $mailfrom = 'nkissebe@purdue.edu';
	var $fromname = 'NEEShub';
	var $sendmail = '/usr/sbin/sendmail';
	var $smtpauth = '0';
	var $smtpsecure = 'none';
	var $smtpport = '25';
	var $smtpuser = '';
	var $smtppass = '';
	var $smtphost = 'localhost';
	var $MetaAuthor = '1';
	var $MetaTitle = '1';
	var $lifetime = '120';
	var $session_handler = 'database';
	var $password = 'vBaz57pt';
	var $sitename = 'NEEShub';
	var $MetaDesc = 'Joomla! - the dynamic portal engine and content management system';
	var $MetaKeys = 'joomla, Joomla';
	var $ldap_primary = '';
	var $ldap_secondary = '';
	var $ldap_basedn = '';
	var $ldap_searchdn = '';
	var $ldap_searchpw = '';
	var $ldap_managerdn = '';
	var $ldap_managerpw = '';
	var $ldap_tls = '';
	var $offline_message = 'This site is down for maintenance. Please check back again soon.';
}
?>