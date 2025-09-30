<?php

use App\Http\Router;

Router::post("/auth/login", "AuthController:login");

//Users 

Router::get("/users", "UserController:show");
Router::post("/users", "UserController:store");
Router::put("/users", "UserController:update");
Router::delete("/users", "UserController:delete");

//Accounts

Router::get("/accounts", "AccountsController:index");
Router::get("/accounts/{id}", "AccountsController:show");
Router::post("/accounts", "AccountsController:store");
// Router::put("/accounts/{id}", "AccountsController:update");
Router::delete("/accounts/{id}", "AccountsController:delete");

//Transaction

Router::post("/transfers", "BankTransferController:moneyTransfer");





?>