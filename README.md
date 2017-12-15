<p align="center"><a href="http://nfqakademija.lt/" target="_blank"><img src="https://avatars0.githubusercontent.com/u/4995607?v=3&s=100"></a><a href="https://symfony.com" target="_blank">
    <img src="https://symfony.com/logos/symfony_black_02.svg">
</a></p>

Discounted Food
========================

[![Build Status](https://travis-ci.org/mantas-kemesius/Discounted_food_app.svg?branch=master)](https://travis-ci.org/mantas-kemesius/Discounted_food_app/)

# Project Description
Discounted Food is a demo application created during NFQ Academy. 
Main goal of this application - help restaurants and bakeries 
find customers to sell discounted food at the end of each day.

Keywords: php, symfony, doctrine, mysql.

# How to run this project?

```bash
  $ git clone <project>
  $ cd path/to/<project>
  $ composer install 
  $ php bin/console doctrine:database:create
  $ php bin/console doctrine:schema:update --force
```
For loading sample data
```bash
    $ php bin/console doctrine:fixtures:load
```

