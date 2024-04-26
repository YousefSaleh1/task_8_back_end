# Employee Management System
 Employee Management System (EMS) that allows for managing departments and employees within those departments. The system feature a user authentication mechanism, CRUD operations for managing departments and employees, relationships between departments and employees, soft deletion of records, and an API to interact with the system.


## Installation

You Must run the migrations and seeders:
```bash
php artisan migrate --seed
```


## Usage

You must create an account or log in with the owner account to be able to send all requests


Owner Information :
```json
{
    'name': 'Owner',
    'email': 'owner@gmail.com',
    'password': 'owner1234'
}
```

You Can View The API Documentation via ([The Link](https://documenter.getpostman.com/view/30507236/2sA3Bt3VRR)).
