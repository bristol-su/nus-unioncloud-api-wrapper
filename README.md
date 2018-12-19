# PHP UnionCloud API Wrapper

Toby Twigger (tt15951@bristol.ac.uk) on behalf of Bristol SU (https://www.bristolsu.org.uk).

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tobytwigger/nus-unioncloud-api-wrapper/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tobytwigger/nus-unioncloud-api-wrapper/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/tobytwigger/nus-unioncloud-api-wrapper/badges/build.png?b=master)](https://scrutinizer-ci.com/g/tobytwigger/nus-unioncloud-api-wrapper/build-status/master)

## Installation
Add ``twigger/unioncloud`` as a require dependency in your ``composer.json`` file:

```bash
composer require twigger/unioncloud
```

Require composer's autoload, and point your scripts to the UnionCloud namespace

```php
use \Twigger\UnionCloud\API\UnionCloud as UnionCloudWrapper
```

### Laravel

Support for Laravel is supplied out of the box

#### Configuration

Publish the UnionCloud configuration

```bash
php artisan vendor:publish --provider="Twigger\UnionCloud\API"
```
Add the following to your .env file
```dotenv
UNIONCLOUD_BASEURL=bristol.unioncloud.org
UNIONCLOUD_V0AUTH_EMAIL=myEmail
UNIONCLOUD_V0AUTH_PASSWORD=myPassword
UNIONCLOUD_V0AUTH_APPID=appID
UNIONCLOUD_V0AUTH_APPPASSWORD=appPassword
```

If you're using Laravel <5.5, you'll also need to register the service provider in the ```providers``` array in ```config/app.php```

```php
Twigger\UnionCloud\API\UnionCloudServiceProvider::class
```

To resolve the UnionCloud instance from the Laravel service container

```php
$unionCloud = resolve('Twigger\UnionCloud\API\UnionCloud');
```
This will be set with your authentication parameters and base URL.

## Usage

### Setup

Create a new UnionCloud Wrapper:

```php
$unionCloud = new UnionCloudWrapper($auth);
```

This takes an associative array of authentication parameters. For example,

```php
$auth = [
	'email'=>'tt15951@bristol.ac.uk',
	'password'=>'top_secret',
	'appID'=>'MyAppID',
	'appPassword'=>'myPass'
];
```

Set all relevant global configuration values. These are currently the base URL and the debug option.

 - The base URL is in the format `` 'bristol.unioncloud.org' ``.
 - Debug will return information about the raw request and response. You may still access meta data (such as the status code) out of debug mode.
 
```php
$unionCloud->setBaseURL('union.unioncloud.org') ;
$unionCloud->debug();
```

### Making Requests
Any requests made take the following format:

- Resource to  interact with
- Request specific configurations
- Specific API call to make
- Format to receive the data in

If your IDE supports DocBlocks, you should have hints at all available resources and methods.

#### Resource to interact with
These take the plural form of the resource name in camelCase. For example,

```php 
users()
userGroupMemberships()
```

A resource specific request class will be returned, containing all methods available to that resource.

#### Request specific configurations
This allows you to change the specifics of your API call. The following methods are available
```php
setMode($mode) // Takes basic, standard or full. Defaults to full
paginate()
setPage($page)
```

- ``setMode()`` allows you to alter the mode you make the request in. UnionCloud takes ``basic|standard|full`` as options. Defaults to full.
- ``paginate()`` should be used to enable the pagination functions.
-``setPage`` may be used alongside ``paginate()`` to retrieve a specific page. This, however, will rarely be used since the default page is ``1``.

#### Specific API call
You may now make a call to the correct API endpoint. The Request class contains instructions for the BaseRequest class as to how to create the API request. For example, you may call the ``search()`` function in the UserRequest class. This takes an array of parameters to search by.

Look at your IDE hints to determine which methods are available to you.

#### Format to recieve the response in
To make interacting with UnionCloud as simple as possible, you may request different types of response class. You may recieve one of the following:

- Request Class
	- If you use the paginate() function, you will recieve a request class, however the function getResponse() will return the saved response. See the pagination section for more details.
- Response Class
	- This is the normal response method. This returns a class with a load of information about the request, such as the status code, page numbers etc. If debugging is turned on, this class also holds information about the request made.
	- Use the get() function to retrieve the data from the response class. This will be given in a ResourceCollection class.
- ResourceCollection class
	- A Resource Collection is simply a collection of resources. We use a custom collection class to introduce useful features for manipulating responses.
	- For example, you may use the first() function to get the first resource returned.
- Resource Class
	- This is the class in which the data for a resource is held. For example, there is a User Resource class, which contains information about the user.
	
#### Chaining

In order to achieve clean code, chaining is allowed. The following line will search for a user called ``Toby`` and return the first user as a UserResource class. We assume $unionCloud contains a UnionCloud class which has the correct authentication parameters passed.

```php
$user = $unionCloud->users()->search(['forename'=>'Toby'])->get()->first();
```

We could also specify the mode to search by.

```php
$user = $unionCloud->users()->setMode('basic')->search(['forename'=>'Toby'])->get()->first();
```

Or if we wanted to check the request was successful:
```php
if($unionCloud->users()->setMode('basic')->getByUID('1234567')->getStatusCode() === 200) {
	// Request was successful
}
```

### Using ResourceClasses

To make developing with UnionCloud easier,  we provide data in a ResourceClass. There is a ResourceClass per resource, which may contain helpful functions to interact with that resource. For example, the UserResource class may contain a function called isOver18(), which will check if the user is over 18.

To access variables present in a resource class, just treat them as class properties. Given $user contains a populated UserResource class, the following may be used to look at information about a particular user
```php
$user->forename
$user->dob
...
```

### Casting
To further improve workflows, we automatically cast certain parameters to a specific type. For example, a date field will be shows as a Carbon instance, and a name field will be correctly capitalised.

#### Basic Casting
You don't have to worry about casting manually unless you're developing or modifying a Resource class.

In the Resource class, there is a variable called $casts. This defines the resource attribute keys, and the format we should cast it to. Currently the available options are

- date (Carbon Instance)
- properCase (Format a name)
- ```AnotherResourceClass::class```

```AnotherResourceClass::class``` allows us to cast specific return attributes into alternate Resource classes. Say a user has a UserGroup Membership attribute returned, which contains an array of UserGroup Memberships. We may speficy the usergroup membership attribute should be casted into a UserGroup Memberhip Resource class by setting ```$casts``` to the following.
```php
$casts = [
	'userGroupMemberships' => UserGroupMembershipResource::class
];
```

We will pass each usergroup membership into the resource constructor to produce a resource class for each membership.

Always use camelCase for specifying attributes!

#### Advanced Casting
For some API calls, two or more resources are returned in the same array. For example, the following may be returned:

```php
$event = [
	'user_uid' => 22222,
	'user_forename' => 'Toby',
	'event_id' => 3848,
	`event_name` => `Event the user 22222 set up`
];
``` 

In this case, use the $customCasts array. Each key should contain the new attribute you want to create and the new resource class to insert into that attribute, seperated with a pipe. The value should be an array of mappings, from the current attributes to the new resource attributes. In the above example, if we wanted the data to look like

```php
	$event = [
		'setup_user' => UserResource[
			'uid' => 22222,
			'forename' => 'Toby'
		].
		'event_id' => 3848,
		'event_name' => 'Event the user 22222 set up'
	];
```

we could specify the following cast

```php
$customCasts = [
	'setup_user|'.UserResource::class => [
		'user_uid' => 'uid',
		'user_forename' => 'forename'
	],
	...
];
```

### Pagination

Pagination only applies if the API has been set up to handle pagination. By this, we mean in the API Instructions (the method in the specific Request Class), the function $this->enablePagination() has been called.

The developer using this repo must also request pagination functionality for each api call. This can be done by, for example
```php
$users = $unionCloud->users()->paginate()->search(['forename', 'Toby'])
```

This will return a UserRequest class.

The following methods are now available to be used:
```php
$users->getResponse(); // Get the UserResponse class for the first page
$users->getAll(); // Return a collection containing all users. This will iterate through pages until the final page is reached, so may take a while (although syncronous requests are coming!)
$users->next(); // Return the RequestClass containing the response to the next page.
$users->previous(); // Return the RequestClass containing the response to the previous page.
```

# Contributing

This is an unfinished repository, any any contributions would be welcomed! The following is an incomplete list of things to be done.

- Most the request classes have to be populated with their methods
- Most the resource classes have to be populated with casting information and useful resource specific functions.
- An authenticator for AWS needs to be written

# Repository Documentation

The automatically generated phpDocumentor documentation may be found on Github Pages
[phpDoc Documentation](https://tobytwigger.github.io/nus-unioncloud-api-wrapper/)
