---
layout: default
title: Architecture
nav_order: 3
has_children: true
---

# Architecture

This application uses a layered architecture and the Action Domain Responder (ADR) pattern for HTTP.  

## Action Domain Responder

**ADR** is a user interface pattern specifically intended for server-side applications operating in an over-the-network, request/response environment.

The modern derivations of "MVC Model 2" toward Action Domain Responder is not difficult. 

* **[Action](action.md):** The controller that mediates between Domain and Responder.
* **[Domain](domain.md):** The core application with the business logic.
* **[Responder](responder.md):** The view with the presentation logic.

## Request and Response

A quick overview of the request/response cycle:

![image](https://user-images.githubusercontent.com/781074/67461691-3c34a880-f63e-11e9-8266-2119ac98f639.png)

## Read more

This architecture was inspired by the following resources and books:

* [Software Architecture for Web Applications and APIs](https://ko-fi.com/s/811e7a3593)
* [Action Domain Responder](https://pmjones.io/adr/)
* [The Clean Architecture](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)
* [Domain-Driven Design](https://amzn.to/3cNq2jV) (The blue DDD book)
* [Implementing Domain-Driven Design](https://amzn.to/2zrGrMm) (The red DDD book)
* [The Beauty of Single Action Controllers](https://driesvints.com/blog/the-beauty-of-single-action-controllers)
* [Object Design Style Guide](https://www.manning.com/books/object-design-style-guide?a_aid=object-design&a_bid=4e089b42)
* [Advanced Web Application Architecture](https://leanpub.com/web-application-architecture/) (Book)
* [Advanced Web Application Architecture](https://www.slideshare.net/matthiasnoback/advanced-web-application-architecture-full-stack-europe-2019) (Slides)
* [Hexagonal Architecture](https://fideloper.com/hexagonal-architecture)
* [Hexagonal Architecture demystified](https://madewithlove.be/hexagonal-architecture-demystified/)
* [Alistair in the Hexagone](https://www.youtube.com/watch?v=th4AgBcrEHA)
