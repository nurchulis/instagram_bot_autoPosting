# instagram_bot_autoPosting
This Instagram Auto Posting Manager Frok with https://instagrambot.github.io/docs/en/


![N|Solid](https://raw.githubusercontent.com/nurchulis/instagram_bot_autoPosting/master/Cover.png)

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)

InstaMultiPost is a Program with php and modifed instabot can posting auto rotate many own account .
  - PHP
  - Python
  - Mysqli

# Features!

  - Auto Posting Rotate Account 
  - Manage Posting (Caption, Photo) Random or shame Posting
  - Manage Account User 

### DEMO

![N|Solid](https://raw.githubusercontent.com/nurchulis/instagram_bot_autoPosting/master/2.png)

![N|Solid](https://raw.githubusercontent.com/nurchulis/instagram_bot_autoPosting/master/3.png)

![N|Solid](https://raw.githubusercontent.com/nurchulis/instagram_bot_autoPosting/master/4.png)

![N|Solid](https://raw.githubusercontent.com/nurchulis/instagram_bot_autoPosting/master/5.png)

![N|Solid](https://raw.githubusercontent.com/nurchulis/instagram_bot_autoPosting/master/6.png)



### Installation

Dillinger requires [Node.js](https://nodejs.org/) v4+ to run.

Install the dependencies and devDependencies and start the server.

```sh
$ cd instagram_bot_autoPosting
$ pip install -U instabot
$ pip install Flask
$ python run.py
```

```sh
$ cd etc/
$ crontab -e
$ edit set * * * * * wget -O- http://127.0.0.1:5000/cron_job_now > /dev/null 2>&1
```

### Managebroswer Aplication

Want to contribute? Great!

Dillinger uses Gulp + Webpack for fast developing.
Make a change in your file and instantaneously see your updates!

Open your favorite Terminal and run these commands.

```sh
$ import robot_ig databse to phpmyadmin or mysql databse
$ set username and password
$ open in your localhost/your_app/web
```


### Todos

 - Write MORE Tests
 - Add Logs error

License
----

MIT


**Free Software, Hell Yeah!**

[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)


   [dill]: <https://github.com/joemccann/dillinger>
   [git-repo-url]: <https://github.com/joemccann/dillinger.git>
   [john gruber]: <http://daringfireball.net>
   [df1]: <http://daringfireball.net/projects/markdown/>
   [markdown-it]: <https://github.com/markdown-it/markdown-it>
   [Ace Editor]: <http://ace.ajax.org>
   [node.js]: <http://nodejs.org>
   [Twitter Bootstrap]: <http://twitter.github.com/bootstrap/>
   [jQuery]: <http://jquery.com>
   [@tjholowaychuk]: <http://twitter.com/tjholowaychuk>
   [express]: <http://expressjs.com>
   [AngularJS]: <http://angularjs.org>
   [Gulp]: <http://gulpjs.com>

   [PlDb]: <https://github.com/joemccann/dillinger/tree/master/plugins/dropbox/README.md>
   [PlGh]: <https://github.com/joemccann/dillinger/tree/master/plugins/github/README.md>
   [PlGd]: <https://github.com/joemccann/dillinger/tree/master/plugins/googledrive/README.md>
   [PlOd]: <https://github.com/joemccann/dillinger/tree/master/plugins/onedrive/README.md>
   [PlMe]: <https://github.com/joemccann/dillinger/tree/master/plugins/medium/README.md>
   [PlGa]: <https://github.com/RahulHP/dillinger/blob/master/plugins/googleanalytics/README.md>
