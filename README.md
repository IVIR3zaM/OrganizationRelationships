#Organization Relationships

This is a test for a company, if you detected the company and you're supposed to do the same,
please don't investigate this repository. just go and try for yourself :-)

This project is a RestFul Api that implemented by Symfony 3.4 base on PHP 7.0 and MySql database.


## Project Description

The goal of this task it to create a RESTful service that stores organisations with relations
(parent to child relation). Organization name is unique. One organisation may have multiple
parents and daughters. All relations and organisations are inserted with one request (endpoint
1).

API has a feature to retrieve all relations of one organization (endpoint 2). This endpoint
response includes all parents, daughters and sisters of a given organization. Good luck!

**Additional requirements:**
1. Accepted programming languages: PHP, Node.js
2. Database: MySQL, SQLite or PostgreSQL

### The service endpoints:

1) REST API endpoint that would allow to add many organization with relations in one
POST request:

```json
{
  "org_name": "Paradise Island",
  "daughters": [
    {
      "org_name": "Banana tree",
      "daughters": [
        {
          "org_name": "Yellow Banana"
        },
        {
          "org_name": "Brown Banana"
        },
        {
          "org_name": "Black Banana"
        }
      ]
    },
    {
      "org_name": "Big banana tree",
      "daughters": [
        {
          "org_name": "Yellow Banana"
        },
        {
          "org_name": "Brown Banana"
        },
        {
          "org_name": "Green Banana"
        },
        {
          "org_name": "Black Banana",
          "daughters": [
            {
              "org_name": "Phoneutria Spider"
            }
          ]
        }
      ]
    }
  ]
}
```

2) REST API endpoint that returns relations of one organization (queried by name). All
organization daughters, sisters and parents are returned as one list. List is **​ordered by
name**​ and one page may ​**return 100 rows**​ at max with pagination support. For example
if you query relations for organization “Black Banana”, you will get:

```json
[
  {
    "relationship_type": "parent",
    "org_name": "Banana tree"
  },
  {
    "relationship_type": "parent",
    "org_name": "Big banana tree"
  },
  {
    "relationship_type": "sister",
    "org_name": "Brown Banana"
  },
  {
    "relationship_type": "sister",
    "org_name": "Green Banana"
  },
  {
    "relationship_type": "daughter",
    "org_name": "Phoneutria Spider"
  },
  {
    "relationship_type": "sister",
    "org_name": "Yellow Banana"
  }
]
```

3) Think about the performance and be prepared to discuss on it:

1. Could this service perform well even with up to 100K relations per one organization?

2. What would you change in architecture if 1M relations support is needed?
