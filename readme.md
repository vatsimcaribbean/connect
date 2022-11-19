# VATSIM Connect Standard PHP OAuth 2 Authentication

### Installation & Use

#### 1. Register your Organization on Connect
To utilize Connect, you will need to go to https://auth.vatsim.net/ and create your organization. 

#### 2. Create your site, set redirect URL and IP
Once your organization has been created and approved, you will then view the organization and select OAuth. You will create a New Site. The redirect URL will be the URL where the index file is located. This URL will also be the exact URL you put into the $redirectURL variable. You will also need to define the IP address of the server.

#### 3. Set your variables
You will place your Client ID and Client Secret variables from the OAuth Clients page into your variables. 
Next, you will input your scopes, or, what data you'd like returned to you. Commonly, the following scopes are used: 
```
full_name email vatsim_details country
```
Finally, you will input your redirect URL, login denied URL, and logout URLs.

#### 4. Use of data
At the very bottom of the file, you will find the various data variables defined. Below these, you will find an area between the comment lines to input your code for use of the data captured.

#### Dev Environment
There is a dev environment available to test your application before utilizing the production version of Connect. The dev environment is located at: https://auth-dev.vatsim.net/. This is where you can create your testing organization. To have this code use the dev environment instead of the live environment, change the URLs in lines 18-20 from auth.vatsim.net to auth-dev.vatsim.net.


#### Additional information and support can be found on the offical [@vatsimnetwork](https://github.com/vatsimnetwork/) developer information Wiki: https://github.com/vatsimnetwork/developer-info/wiki


### Credits
- [OAuth 2.0 Client by The League of Extraordinary Packages](http://oauth2-client.thephpleague.com/)
- VATSIM Connect Modifications by Jannes van Gestel and Alex Long
