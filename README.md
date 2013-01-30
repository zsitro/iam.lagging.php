iam.lagging.php
===============

PHP script that emulates lagging server responses so you can test your ajax or whatever

##DEMOS

 * http://dev3.zsitro.com/iamlagging/?lag=3
 * http://dev3.zsitro.com/iamlagging/?lag=3&response=json
 * http://dev3.zsitro.com/iamlagging/?lag=3&response=json&status=201
 * http://dev3.zsitro.com/iamlagging/?response=jpg
 * http://dev3.zsitro.com/iamlagging/?response=jpg&width=800&height=600
 * http://dev3.zsitro.com/iamlagging/?status=500
 * http://dev3.zsitro.com/iamlagging/?status=404


## PARAMETERS
```
@param {Integer} lag		- response delay in seconds
@param {String} response	- response content-type
		* html
		* txt
		* json
		* js
		* css
		* xml
		* png
		* jpg
		* gif

@param {String} status		- response status-code
 
		* 200, 201 ... 500
 
@param {Integer} width		- output image's width in pixels (available only for png,jpg,gif)
@param {Integer} height		- output image's height in pixels (available only for png,jpg,gif)
```

##EXAMPLE USAGES:

```
Delay response by 3 seconds

	  ?lag=3

.. and it should be json

		?lag=3&response=json

.. ohh I need a nifty response status code

		?lag=3&response=json&status=201

.. wait, I rather load a jpg with grumpycat face (without lag)

		?response=jpg

.. thats nice, but I want a 800 x 600 image

		?response=jpg&width=800&height=600
```
