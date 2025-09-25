<?php

use App\Http\Router;

Router::post("/auth/login", "AuthController:login");

//Users 

Router::get("/users", "UserController:fetch");
Router::post("/users", "UserController:store");
Router::put("/users", "UserController:update");
Router::delete("/users/{id}", "UserController:delete");

//Accounts

// Router::get("/accounts/fetch", "AccountsController:fetch");
// Router::post("/accounts/create", "AccountsController:store");
// Router::put("/accounts/update", "AccountsController:update");
// Router::delete("/accounts/delete/{id}", "AccountsController:delete");





?>