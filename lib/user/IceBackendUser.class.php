<?php

class IceBackendUser extends sfGuardSecurityUser
{
  public function getName()
  {
    return $this->getUsername();
  }

  public function getAvatarUrl()
  {
    return 'http://animexarchiculture.files.wordpress.com/2009/04/mystery_man.jpg';
  }

  public function beginAuthentication($trust_url, $return_url = 'http://backend.icepique.com/openid')
  {
    $this->_doIncludes();

    $store = new Auth_OpenID_FileStore(sys_get_temp_dir());
    $consumer = new Auth_OpenID_Consumer($store);

    // Apply the changes for Google Apps OpenID
    new GApps_OpenID_Discovery($consumer);

    // Start the procedure...
    $auth_request = $consumer->begin('icepique.com');
    $redirect_url = $auth_request->redirectURL($trust_url, $return_url);

    if (Auth_OpenID::isFailure($redirect_url))
    {
      return false;
    }
    else
    {
      return $redirect_url;
    }
  }

  public function completeAuthentication($return_to = 'http://backend.icepique.com/openid')
  {
    $this->_doIncludes();

    $store = new Auth_OpenID_FileStore(sys_get_temp_dir());
    $consumer = new Auth_OpenID_Consumer($store);

    // Apply the changes for Google Apps OpenID
    new GApps_OpenID_Discovery($consumer);

    $response = $consumer->complete($return_to);

    if ($response->status == Auth_OpenID_SUCCESS && $openId = $response->getDisplayIdentifier())
    {
      if (!$user = sfGuardUserQuery::create()->findOneByUsername($openId))
      {
        $user = new sfGuardUser();
        $user->setUsername($openId);
        $user->setPassword(iceStatic::getUniquePassword());
        $user->save();
      }

      // Finally set the user as authenticated
      $this->signIn($user);

      return true;
    }

    return false;
  }

  protected function getTrustRoot()
  {
    return sprintf(
      "http://%s:%s%s/",
      $_SERVER['SERVER_NAME'], $_SERVER['SERVER_PORT'], dirname($_SERVER['PHP_SELF'])
    );
  }

  protected function _doIncludes()
  {
    sfToolkit::addIncludePath(dirname(__FILE__) .'/../vendor', 'back');

    /**
     * Require the OpenID consumer code.
     */
    require_once "Auth/OpenID/Consumer.php";

    /**
     * Require the "file store" module, which we'll need to store
     * OpenID information.
     */
    require_once "Auth/OpenID/FileStore.php";

    /**
     * Require the Simple Registration extension API.
     */
    require_once "Auth/OpenID/SReg.php";

    /**
     * Require the PAPE extension module.
     */
    require_once "Auth/OpenID/PAPE.php";

    /**
     * Require the Google Discovery extension module.
     */
    require_once "Auth/OpenID/GoogleDiscovery.php";
  }
}
