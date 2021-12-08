## Introduction
This repository introduces a simple microservices application that handles the users registration. It's mainly register a new user then sending him an email notification to welcome him into the system.
<br />
There're two services includes in this application. The first one is a Laravel service that handles the user registration main request via Restful API, validating his data, and then storing it to a MySQL database. 
The second one is a Django service that sends an email notification to the user when he successfully registers. The notification get stored in a MongoDB database.

 ## Services
 ### Registration Service
 This service mainly uses PHP and Laravel framework to handle the user registration via Restful API. The request parameters are being validated via `App\Http\Requests\RegisterRequest`. After that, the `App\Services\AuthService::store($data)` is being called to store the user's data in the users table in its MySQL database.
 <br />
 After a new user is being created, the user observer will be fired immediatly after the creation to publish a new message to a kafka topic called `email-notifications` to notify the other service about the action using `App\Observers\UserObserver::created(User $user)`

 ### Notification Service
 This service mainly uses Python and Django framework to handle the user registration notification. It's mainly running a command called `run_consumer` that starts a new kafka consumer on the `email-notifications` topic.
<br />
 After the consumer receives a new message from the broker, it will send him an email using the user data sent within the message. And then, a new notification will be created in the MongoDB database in the `notifications` collection.

 ## System Architecture

![System Architecture](https://i.ibb.co/RhknmbN/Link.png)

 ## Docker
 Find the system docker here [Docker Repository](https://github.com/MohannadElemary2/microservices-docker)

 ## API Documentation
 Find the Postman collection here [Postman Collection](https://documenter.getpostman.com/view/8868758/UVJkBZBL)
