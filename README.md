symfony-starter-kit
=======

Decoupled-backend Starter Kit to use with Angular front-end decoupled project


###Getting Started

###1. Clone Repo
```
git clone --bare git@github.com:caxy/symfony-starter-kit.git
cd symfony-starter-kit
git push --mirror {NEW_GITHUB_REPO_LINK}
cd ../
rm -rf symfony-starter-kit

git clone {NEW_GITHUB_REPO_LINK}
cd {NEW_REPO_NAME}

```

###2. Install Packages & fill-out parameters
```
composer install
bash dev-setup.sh
```

###3. Setup Database & Load Fixtures
```
bin/console d:d:c
bin/console d:s:c
bin/console d:f:l -n
```

###4. Fix your permissions (advanced)
   
   See [Setting up Permissions](http://symfony.com/doc/2.3/book/installation.html#checking-symfony-application-configuration-and-setup) in the Symfony book.
    
macOS

```
HTTPDUSER=`ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
sudo chmod -R +a "$HTTPDUSER allow delete,write,append,file_inherit,directory_inherit" var
sudo chmod -R +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" var
```

Linux/BSD
```
HTTPDUSER=`ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
#if this doesn't work, try adding `-n` option
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var
```

###5. JWT Setup

```
mkdir -p var/jwt # For Symfony3+, no need of the -p option
openssl genrsa -out var/jwt/private.pem -aes256 4096
openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem
```

###6. Important note for Apache Users

Apache server will strip any Authorization header not in a valid HTTP BASIC AUTH format.

If you intend to use the authorization header mode of this bundle (and you should), please add those rules to your VirtualHost configuration :
```
RewriteEngine On
RewriteCond %{HTTP:Authorization} ^(.*)
RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]
```

###7. Confirm

   Run the Symfony built in web server with highest verbosity.
   
   ```bash
   bin/console server:run -vvv
   ```
   
   Then run a command that should return an authentication error:
   
   ```bash
   curl http://localhost:8000/api/users/1
   ```
   
   The response should be:
   
   ```json
   {"code":401,"message":"Invalid credentials"}
   ```
   
   If PHP is misconfigured, it may report errors that include directions for changing the `php.ini` file during
   any of the above steps.
   
   ###8. Testing the API
   
   To Test the built in tests run:
   ```
   phpunit
   ```
   
   First Generate a JWT Token, from Terminal:
   ```
   #username can be any user in the database, user, admin, superadmin are available from the fixutres.
   bin/console generate:token {username}
   ```
   
   The output will give you a long string, copy that and paste it into the url where it says {INSERT TOKEN HERE}
   
   
   To Test the API, browse to localhost:8000/api/doc?bearer={INSERT TOKEN HERE}
   Do not confuse this with localhost:8000/api, they are separate, and will not function without the JWT Token.
   
   Once on localhost:8000/api/doc?bearer={INSERT TOKEN HERE}, You need to set the token again in the input in the upper right where it says 'api key:' and press save. Then you can start using endpoints.
