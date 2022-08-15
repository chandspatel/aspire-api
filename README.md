
## Aspire Mini API

Follow below step to run the App.

- Clone the repository from [Github](https://github.com/chandspatel/aspire-api.git)
- After clone project go to that folder and open terminal and hit command 

  **composer update**
- Before migration create database('aspire_db') in your phpmyadmin.
  now hits command **php artisan migrate --seed** .
- To access API start server by hitting command **php artisan serve**

- You can run Feature Test by hitting command **php artisan test**

## Testing API

This API is developed in laravel  8.83.23 and required PHP version >= 8

**Postman Json link :**

https://www.getpostman.com/collections/b3bdd624417659839b03


**Default Admin Credentils:**

**Email:** admin@gmail.com

**Password :** 123456



 **1) API for customer and admin Registration.**

    **API** :  http://localhost:8000/api/register
    
    **Method** :POST
    
    **Json Params** :
    {
        "name" : "chands",
        "email" : "chands@gmail.com",
        "password" : "123456",
        "password_confirmation" : "123456",
        "user_type" : "0"
    }
    Note : user_type : 0 for customer and 1 for admin registration
    
    **headers**
        Accept : application/json

    **Success Response**
    
    {
        "message": "Registration Completed Successfully!",
        "user": {
            "name": "chands",
            "email": "chands@gmail.com",
            "updated_at": "2022-08-13T14:12:06.000000Z",
            "created_at": "2022-08-13T14:12:06.000000Z",
            "id": 6
        },
        "token": "13|DgVmZXqXj3B4GNxMjLjSjV149Y2VoFVflEGw2Rbk",
        "code": 200
    }

    **Fail Response**
    
    {
        "message": "The given data was invalid.",
        "errors": {
            "email": [
                "The email has already been taken."
            ]
        }
    }


 **2) API for customer and admin login.**

    **API** :  http://localhost:8000/api/login
    
    **Method** :POST
    
    **Json Params** :
    {
        "email" : "chands@gmail.com",
        "password" : "123456",
        "user_type" : "0"
    }
    Note : user_type : 0 for customer and 1 for admin login
    

    **headers**
        Accept : application/json

    **Success Response**
    
    {
        "message": "Login successfully!",
        "user": {
            "id": 1,
            "name": "Admin",
            "email": "chands@gmail.com",
            "email_verified_at": null,
            "user_type": 1,
            "created_at": "2022-08-13T09:26:45.000000Z",
            "updated_at": "2022-08-13T09:26:45.000000Z"
        },
        "token": "11|ypVXtzEsYozQclI4XCM84rsik4Bne7B5POd4Werj"
    }

    **Fail Response**
    
    {
        "message": "invalid credentials",
        "code": 400
    }


 **3) API for create loans.**

    **API** :  http://localhost:8000/api/create-loan
    
    **Method** :POST
    
    **Json Params** :
    {
        "loan_amount": "500",
        "loan_term": "5"
    }
    
    **Authorization** :
        Bearer Token : Here need to pass token which you have get from login/registation API.

    **headers**
        Accept : application/json

    **Success Response**
    
    {
        "message": "Loan created successfully!",
        "code": 200
    }

    **Fail Response**
    
    {
        "message": "Something went wrong!",
        "code": 400
    }


 **4) API for get loans.**

    Returns authenticated customers loan details , if admin access this API then all customer's loans will be show to admin.

    **API** :  http://localhost:8000/api/loans
    
    **Method** :GET
    
    **Json Params** :
    {
        "loan_amount": "500",
        "loan_term": "5"
    }
    
    **Authorization** :
        Bearer Token : Here need to pass token which you have get from login/registation API.

    **headers**
        Accept : application/json


    **Success Response**
    
    {
        "data": [
             {
                "id": 8,
                "user_id": 2,
                "loan_amount": 500,
                "loan_term": 5,
                "status": "pending",
                "created_at": "2022-08-13 14:23:20",
                "updated_at": "2022-08-13 14:23:20",
                "loan_repayments": [
                    {
                        "id": 34,
                        "loan_id": 8,
                        "repayment_amount": 100,
                        "repayment_date": "2022-08-20",
                        "status": "pending",
                        "created_at": "2022-08-13 14:23:20",
                        "updated_at": "2022-08-13 14:23:20"
                    },
                    {
                        "id": 35,
                        "loan_id": 8,
                        "repayment_amount": 100,
                        "repayment_date": "2022-08-27",
                        "status": "pending",
                        "created_at": "2022-08-13 14:23:20",
                        "updated_at": "2022-08-13 14:23:20"
                    },
                    {
                        "id": 36,
                        "loan_id": 8,
                        "repayment_amount": 100,
                        "repayment_date": "2022-09-03",
                        "status": "pending",
                        "created_at": "2022-08-13 14:23:20",
                        "updated_at": "2022-08-13 14:23:20"
                    },
                    {
                        "id": 37,
                        "loan_id": 8,
                        "repayment_amount": 100,
                        "repayment_date": "2022-09-10",
                        "status": "pending",
                        "created_at": "2022-08-13 14:23:20",
                        "updated_at": "2022-08-13 14:23:20"
                    },
                    {
                        "id": 38,
                        "loan_id": 8,
                        "repayment_amount": 100,
                        "repayment_date": "2022-09-17",
                        "status": "pending",
                        "created_at": "2022-08-13 14:23:20",
                        "updated_at": "2022-08-13 14:23:20"
                    }
                ],
                "user": {
                    "id": 2,
                    "name": "chands",
                    "email": "chands@gmail.com",
                    "email_verified_at": null,
                    "user_type": 0,
                    "created_at": "2022-08-13T09:27:50.000000Z",
                    "updated_at": "2022-08-13T09:27:50.000000Z"
                }
            }
        ],
        "code": 200
    }

    **Fail Response**
    
    {
        "message": "Unauthenticated."
    }



 **5) API for approve loans.**

    Only admin can access this API.

    **API** :  http://localhost:8000/api/approve-loans
    
    **Method** :POST
    
    **Json Params** :
    {
        "loan_id": "1"
    }
    
    Note  : You can get "loan_id" from /api/loans API's response ->data[n]->id.

    **Authorization** :
        Bearer Token : Here need to pass token which you have get from login/registation API.

    **headers**
        Accept : application/json


    **Success Response**
    
    {
        "data": {
            "id": 1,
            "user_id": 3,
            "loan_amount": 124,
            "loan_term": 3,
            "status": "approved",
            "created_at": "2022-08-13 10:01:54",
            "updated_at": "2022-08-13 12:31:04"
        },
        "message": "Loans approved successfully!"
    }

    **Fail Response**
    
    {
        "message": "Customer can not access this API",
        "code": 400
    }



 **6) API for repayment loans amount.**

    Pending status of loans repayment can be completed if status is paid then error message will be display.

    **API** :  http://localhost:8000/api/repayment-loans-amount
    
    **Method** :POST
    
    **Json Params** :
    {
        "repayment_loan_id": "1",
        "repayment_loan_amount": "100"
    }
    
    Note  : You can get "repayment_loan_id" from /api/loans API's response ->data[n]->loan_repayments[m]->id.
    
    **Authorization** :
        Bearer Token : Here need to pass token which you have get from login/registation API.

    **headers**
        Accept : application/json


    **Success Response**
    
    {
        "message": "Loans repayment paid successfully!",
        "code": 200
    }

    **Fail Response**
    
    {
        "message": "Loans repayment detail not found!",
        "code": 400
    }



 **7) API for customer and admin logout.**


    **API** :  http://localhost:8000/api/logout
    
    **Method** :POST
    
    **Authorization** :
        Bearer Token : Here need to pass token which you have get from login/registation API.

    **headers**
        Accept : application/json


    **Success Response**
    
    {
        "message": "You are logged out!",
        "code": 200
    }

    **Fail Response**
    
    {
        "message": "Unauthenticated."
    }
