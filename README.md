# restphullp
## Restphull P - PHP Restfull Framework

Restphull P is a framework that give you a easy way to create a restfull apis to communicate to your system.

The idea behind our framework is simplify the development where the developer has to create only the model (with the properties, getters and setters) and a blank controller to obtain the access to the 4 http methods (GET, POST, PUT and DELETE).

### HTTP METHODS

The restfull api consist into 4 methods to controll your system:

* **GET**: READ the data based in your model. If you want to list all rows from correspondent table, you may call the url without any parameter: ```http://api.myurl/```; else if you want to get a specific row data you may call passing it id: ```http://api.myurl/id```;
* **POST**: CREATE a new entry on the correspondent model table. You need to pass the required fields through the http content data;
* **PUT**: UPDATE an especific row based on given id. You need to pass all the fields you want to update though the http content data. It is necessary to inform the id at the end of url ```PUT: http://api.myurl/id```;
* **DELETE**: DELETE a given row through the id at the end of url.

### HOW TO USE

If you want to use this framework you need to clone this repository or download the source code and:

1. Configure your database access in the file ```api/config.php```;
2. Create your models into the folder ```api/models```;
3. Create your blank controllers into the folder ```api/controllers```;

### HOW TO TEST

You can test your api using the curl program passing ```-X``` parameter informing the HTTP REQUEST METHOD and passing the data though the ```--data``` parameter when necessary.
```curl -x POST http://api.myurl/ --data {"key1":"value1", "key2":"value2"}```.

You may use the [Postman Chrome Extension](https://chrome.google.com/webstore/detail/postman-rest-client/fdmmgilgnpjigdojojpjoooidkmcomcm) to test the api.

### JSON TRANSFER

The framework works transfering json data, so the content from request and response have to be in json format.

### WE ARE ALPHA

This framework is still in alpha. We are changing many concepts and creating others. So, it is recommended DO NOT use it.

### TODO

There is a list of things I hope to implement into this framework. That is it:

1. Test a number of GET parameters and call child implementation of many get methods. Like ```GET: http://api.myurl/user/user_id/friend/```;
2. Authenticate the user and generate tokens to access the api;
3. Separate private and public methods to use or not the token auth;
4. Create a way to get '1 to n' and 'm to n' relationship on database; 
5. Create filter. Like ```http://api.myurl/users/?nome=John```, ```http://api.myurl/users/?nome=(type:like, Jo)```, ```http://api.myurl/users/?id=(type:in,10,26,88)``` and ```http://api.myurl/log/?date=(type:between,2015-05-20,2015-05-22)```;
6. Create pagination. Like ```http://api.myurl/clientes/?offset=0&limit=20``` or ```http://api.myurl/clientes/?pagination=(0,20)```. 



