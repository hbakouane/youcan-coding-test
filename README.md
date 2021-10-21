# YouCan Laravel Coding Test
[Test Link](https://github.com/NextmediaMa/coding-challenges/tree/master/Software%20Engineer)

# ⚙️ Used Technologies

💅 FrontEnd : Css, Bootstrap, Vue

🛠 Backend : PHP 7.4 | Laravel 8

💾 Database : MySql

☁️ Deployment : Github

#### To run this project make sure you ran these commands
<code>composer install</code><br><br>
<code>copy .env.example .env</code><br><br>
<code>php artisan key:generate</code><br><br>
<code>php artisan migrate</code><br><br>
<code>php artisan serve --port=3000</code><br><br>
<code>php artisan storage:link</code><br><br>
now you can visit localhost:3000 and see the project

# CLI
All the following commands are artisan ones, which means you have to run the command like that: <code>php artisan command</code>

---------------------------------------------------------------------------------------------------------
| Command           | Description                      | Arguments                                       |
| ----------------- | ---------------------------------| ------------------------------------------------|
| categories:show   | Shows all the categories         |                                                 |
| category:create   | Creates a new category           | --name --parentId                               |
| category:delete   | Deletes a category by a given ID | --categoryId                                    |
| products:show     | Shows all the products           |                                                 |
| product:create    | Created a new product            | --name--description --categoryId --price --image|
| product:delete    | Deletes a product by a given ID  | --productId                                     |
| test              | Tests the product uploading      |                                                 |
| make:service      | Creates a new service            | --modelName                                                |

### Example
<code>php artisan category:create "Programming" 5</code>
<p>In this example, 5 is the id of the parent category Books.</p>

<p>Let's suppose we want to see all the categories in the CLI</p>
<code>php artisan categories:show</code>

The Output for this will be:

| ID | CATEGORY | PARENT|   
| -- | -------- | ----- |
| 1  | Shirts   | null  |
| 2  | Pants    | null  | 
| 5  | Books    | 5     |

# Web
- Login: localhost:3000/login
- Register: localhost:3000/register
- Browse/create/delete categories: localhost:3000/categories
- Browse/create/delete products: localhost:3000/products
