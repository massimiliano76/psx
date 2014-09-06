
Authentication
==============

Abstract
--------

This chapter shows how to implement authentication for an controller

Basic authentication
--------------------

Basic authentication is the most simple authentication method where a user 
provides an username and password in the header. Note if you use basic 
authentication you should use https since the username and password is 
transported in plaintext over the wire. Add the following method to the 
controller in order to add basic authentication

.. code-block:: php

    <?php

    use PSX\Dispatch\RequestFilter\BasicAuthentication;
    
    ...
    
    public function getPreFilter()
    {
    	$auth = new BasicAuthentication(function($username, $password){
    
    		if($username == '[username]' && $password == '[passsword]')
    		{
    			return true;
    		}
    
    		return false;
    
    	});
    
    	return array($auth);
    }

Oauth authentication
--------------------

Sample oauth authentication. This is only to illustrate what to return. Normally 
you have to check

* is the consumerKey valid
* does the token belongs to an valid request with a valid status
* is the token not expired

PSX calculates and compares the signature if you return an consumer. For more 
informations see :rfc:`5849#anchor`

.. code-block:: php

    <?php
    
    use PSX\Dispatch\RequestFilter\OauthAuthentication;
    use PSX\Oauth\Provider\Data\Consumer;
    
    ...
    
    public function getPreFilter()
    {
    	$auth = new OauthAuthentication(function($consumerKey, $token){
    
    		if($consumerKey == '[consumerKey]' && $token == '[token]')
    		{
    			return new Consumer('[consumerKey]', '[consumerSecret]', '[token]', '[tokenSecret]');
    		}
    
    		return false;
    
    	});
    
    	return array($auth);
    }