FORMAT: 1A
HOST: http://strive.com/api/v1/

# Strive API Documentation
The Strive API provides information and access to users of the Strive application.

## Base API endpoint
All requests to this *Strive API* must prefix their request with /api/v{version}/
Example [https://www.strive.com/api/v1/categories/1/skills]()

## Authentication
        
The *Strive API* uses HTTP basic authentication inside an ssl pipeline. 
Some endpoints do not need the user to be authenticated, but all require ssl.
Endpoints that require authentication will look in the header for the value of **X-Auth-Token**

## Media Types
Where applicable this API uses the [JSON](http://en.wikipedia.org/wiki/JSON) media-type to represent resources states and affordances.


## Error States
The common [HTTP Response Status Codes](http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html) are used.

##Allowed HTTPs requests:

- `POST` - To create resource
- `PUT` - To update resource
- `GET` - To get a resource or list of resources
- `DELETE` - To delete resource

##Description Of Usual Server Responses

- 200 `OK` - the request was successful (some API calls may return 201 instead).
- 201 `Created` - the request was successful and a resource was created.
- 204 `No Content` - the request was successful but there is no representation to return (i.e. the response is empty).
- 400 `Bad Request` - the request could not be understood or was missing required parameters.
- 401 `Unauthorized` - authentication failed or user doesn't have permissions for requested operation.
- 403 `Forbidden` - access denied.
- 404 `Not Found` - resource was not found.
- 429 `Too Many Requests` - exceeded GoodData API limits. Pause requests, wait up to one minute, and try again. 
- 503 `Service Unavailable` - service is temporary unavailable (e.g. scheduled Platform Maintenance). Try again later.

# Group User
Upon authenticating a number of fields will be returned

- All info about the user
- A collection of Skills associated to the User
- A collection of Jobs associated to the User
- A collection of Ratings_for_User
- A collection of Ratings_by_User
- A collection of Groups the User can Authenticate with

## Authentication [/login]

### Login and get a token [POST]
    
+ Request (application/x-www-form-urlencoded)
    
    + Body
    
            username=email
            password=password
        

+ Response 200 (application/json)

        {
            "id":2,
            "email":"jobposter@strive.com",
            "activated":1,
            "activation_code":null,
            "activated_at":null,
            "last_login":null,
            "reset_password_code":null,
            "first_name":"Christiana",
            "last_name":"Cronin",
            "display_name":"lkuphal",
            "profile_image":"http:\/\/api.randomuser.me\/0.3.2\/portraits\/men\/25.jpg",
            "phone_number":"+31(8)8873175718",
            "address1":"603 Sylvester Shoal",
            "address2":null,
            "city":"Wardmouth",
            "state":"NM",
            "zip":"82672-5725",
            "post_membership":null,
            "serviceprovider_membership":null,
            "paypal_cust_id":null,
            "avg_rating":3,
            "locked":0,
            "reported":0,
            "trial_ends_at":null,
            "subscription_ends_at":null,
            "deleted_at":null,
            "created_at":"2014-04-18 01:58:31",
            "updated_at":"2014-04-18 01:58:31",
            "skills":[
                {
                    id: 6
                    name: "Consequatur est cumque."
                    active: 1
                    category_id: 4
                    deleted_at: null
                    created_at: "2014-04-18 01:58:29"
                    updated_at: "2014-04-18 01:58:29"
                    pivot: {
                        job_id: 162
                        skill_id: 6
                    }
                }
            ],
            "jobs":[
                {
                    id: 162
                    posted_by: 28
                    title: "Title of job"
                    max_payrate: 27
                    contact_phone: "053.875.5168x30305"
                    contact_email: "alexa92@hotmail.com"
                    location: null
                    address1: "239 Harris Via Apt. 579"
                    city: "Vivianemouth"
                    state: "MS"
                    zip: ""
                    date_closed: "2014-05-08 21:45:10"
                    active: 1
                    reported: 0
                    deleted_at: null
                    created_at: "2014-04-17 21:45:10"
                    updated_at: "2014-04-17 22:38:02"
                    lat: 0
                    lng: 0
                    skills: [
                        {
                            id: 6
                            name: "Consequatur est cumque."
                            active: 1
                            category_id: 4
                            deleted_at: null
                            created_at: "2014-04-18 01:58:29"
                            updated_at: "2014-04-18 01:58:29"
                            pivot: {
                                job_id: 162
                                skill_id: 6
                            }
                        }
                    ]
                }
            ],
            "ratings_for_user":[
                {
                    id: 50
                    rating: 4
                    review: null
                    rating_by: 3
                    rating_for: 2
                    deleted_at: null
                    created_at: "2014-04-18 01:59:50"
                    updated_at: "2014-04-18 01:59:50"
                }
            ],
            "ratings_by_user":[
                {
                    {
                        id: 50
                        rating: 4
                        review: null
                        rating_by: 3
                        rating_for: 2
                        deleted_at: null
                        created_at: "2014-04-18 01:59:50"
                        updated_at: "2014-04-18 01:59:50"
                    }
                }
            ],
            "groups":[
                {
                    id: 1
                    name: "Users"
                    deleted_at: null
                    created_at: "2014-04-18 01:58:29"
                    updated_at: "2014-04-18 01:58:29"
                    pivot: {
                        user_id: 2
                        group_id: 1
                    }
    
                }
            ],
            "token":"eyJpdiI6IkNoOGlFWGV0QkJlaVBidzQ5bnhhdWpLNm1BU3JJalQ0VFwvMFNkbXJjN2w0PSIsInZhbHVlIjoic2h3Y2p0R2w1cVVcL0pHZ2IyTzhabmZPZVE2UW5kNW9BRFhNcTd4MTR5YzZEYVQ3Y2JmZ2tyanhYcTF2T25KSDVrYU1scE9YcHdVR1I0cHhiUkQzY3hKUkxjK2k4bXlZeTlLV3RGcWNlQkVMRWpRaUlheDZ4amg1bTYxc3hBOFA0aUd2ZktpV1dzOW1wTkZ0SzZ6azY4bXRDcms2bEdVZ0N5a0VDZTArWUxSVT0iLCJtYWMiOiJmYmI4N2UwNTI4NjIxYzBlZjk0MTk3MDYyMjFkYThlZjE2YTljZWI1MDc4NWE0Zjg2ZWNiMTZiMzJmNzFkYWM4In0="
        }
        
## Register [/register]

### Register for new account [POST]
    
+ Request (application/x-www-form-urlencoded)

        email=email
        password=password
        password_confirmation=password
        

+ Response 200 (application/json)

        {
            email: "newemail@strive.com"
            updated_at: "2014-04-20 07:07:19"
            created_at: "2014-04-20 07:07:19"
            id: 105
        }

# Group Categories
Category-related resources of *Strive API*.

The Category resource has the following attributes: 

- id {int}
- name {string}
- active {bool}
- deleted_at {datetime}
- created_at {datetime}
- updated_at {datetime}
- skills  {collection of **Skill** resources}

The states *id*, *created_at*, *updated_at*, and *active* are assigned by the Strive API at the moment of creation. 

## Categories Collection [/categories]
### List all Categories [GET]
+ Response 200 (application/json)

        [
            {
                "id":2,
                "name":"exercitationem",
                "active":1,
                "deleted_at":null,
                "created_at":"2014-04-18 01:58:29",
                "updated_at":"2014-04-18 21:00:45",
                "skills":[
                    {
                        "id":1,
                        "name":"Rerum aperiam consequatur est.",
                        "active":1,
                        "category_id":2,
                        "deleted_at":null,
                        "created_at":"2014-04-18 01:58:29",
                        "updated_at":"2014-04-18 01:58:29"
                    },
                    {
                        "id":8,
                        "name":"Temporibus illo.",
                        "active":1,
                        "category_id":2,
                        "deleted_at":null,
                        "created_at":"2014-04-18 01:58:29",
                        "updated_at":"2014-04-18 01:58:29"
                    }
                ]
            }
        ]

### Auth:Admin | Create a Category [POST]

+ Request  

    + Headers
    
            X-Auth-Token:{?token}
    
    + Body
    
            name:newCategory
        

+ Response 201 (application/json)

        {
            "name":"this is a new category",
            "updated_at":"2014-04-20 01:24:47",
            "created_at":"2014-04-20 01:24:47",
            "id":5
        }

## Category Resource [/categories/{id}]

+ Parameters
    + id (required, integer, `1`) ... Numeric `id` of the Category to perform action with.
    
### Retrieve a single category [GET]
+ Response 200 (application/json)

        [
            {
                "id":5,
                "name":"this is a new category",
                "active":1,
                "deleted_at":null,
                "created_at":"2014-04-20 01:24:47",
                "updated_at":"2014-04-20 01:24:47",
                "skills":[]
            }
        ]

### Auth:Admin | Edit a Category [PUT]

+ Request (application/x-www-form-urlencoded)

    + Headers
    
            +X-Auth-Token:{?token}

    + Body

            name=newCategory%2Name&active=0

+ Response 201 (application/json)

        {
            "id":5,
            "name":"newCategory Name",
            "active":0,
            "deleted_at":null,
            "created_at":"2014-04-20 01:24:47",
            "updated_at":"2014-04-20 01:24:47",
            "skills":[]
        }
        
### Auth:Admin | Delete a Category [DELETE]

+ Request

    + Headers
    
            +X-Auth-Token:{?token}



+ Response 201 (application/json)

        {
            "id":5,
            "name":"newCategory Name",
            "active":0,
            "deleted_at":null,
            "created_at":"2014-04-20 01:24:47",
            "updated_at":"2014-04-20 01:24:47",
            "skills":[]
        }

# Group Skill
Skill-related resources of *Strive API*.

The Skill resource has the following attributes: 

- id {int}
- name {string}
- active {bool}
- deleted_at {datetime}
- created_at {datetime}
- updated_at {datetime}

The states *id*, *created_at*, *active*, and *updated_at* are assigned by the Strive API at the moment of creation. 

## Skills [/categories/{id}/skills]

+ Parameters
    + id (required, integer, `1`) ... Numeric `id` of the Category to perform action with.
   
### List all Skills of given Category [GET]
+ Response 200 (application/json)

        [
            {
                "id":1,
                "name":"Rerum aperiam consequatur est.",
                "active":1,
                "category_id":2,
                "deleted_at":null,
                "created_at":"2014-04-18 01:58:29",
                "updated_at":"2014-04-18 01:58:29"
            },    
            {
                "id":8,
                "name":"Temporibus illo.",
                "active":1,
                "category_id":2,
                "deleted_at":null,
                "created_at":"2014-04-18 01:58:29",
                "updated_at":"2014-04-18 01:58:29"
            }
        ]

### Auth:Admin | Add a new Skill [POST]
+ Request  

    + Headers
    
            X-Auth-Token:{?token}
    
    + Body
    
            name:newCategory
        

+ Response 201 (application/json)

        {
            name: "new skill"
            category_id: "1"
            updated_at: "2014-04-20 07:17:52"
            created_at: "2014-04-20 07:17:52"
            id: 41
        }

# Group Job

## Jobs Collection [/jobs?lat={lat}&lng={lng}]

The latitude and longitude are pulled from the Users GPS and passed to the *Strive API*

### Find Jobs [GET]

+ Parameters
    + lat (required, dec, `39.7391667`) ... Latitude of the Users current location to perform the search with
    + lng (required, dec, `-104.9841667`) ... Longitude of the Users current location to perform the search with
    
+ Response 200 (application/json)

        [
            {
                id: 162
                posted_by: 28
                title: "Title of job"
                max_payrate: 27
                contact_phone: "053.875.5168x30305"
                contact_email: "alexa92@hotmail.com"
                location: null
                address1: "239 Harris Via Apt. 579"
                city: "Vivianemouth"
                state: "MS"
                zip: ""
                date_closed: "2014-05-08 21:45:10"
                active: 1
                reported: 0
                deleted_at: null
                created_at: "2014-04-17 21:45:10"
                updated_at: "2014-04-17 22:38:02"
                lat: 0
                lng: 0
                skills: [
                    {
                        id: 6
                        name: "Consequatur est cumque."
                        active: 1
                        category_id: 4
                        deleted_at: null
                        created_at: "2014-04-18 01:58:29"
                        updated_at: "2014-04-18 01:58:29"
                        pivot: {
                            job_id: 162
                            skill_id: 6
                        }
                    }
                ]
            },
            {
                id: 162
                posted_by: 28
                title: "Title of job"
                max_payrate: 27
                contact_phone: "053.875.5168x30305"
                contact_email: "alexa92@hotmail.com"
                location: null
                address1: "239 Harris Via Apt. 579"
                city: "Vivianemouth"
                state: "MS"
                zip: ""
                date_closed: "2014-05-08 21:45:10"
                active: 1
                reported: 0
                deleted_at: null
                created_at: "2014-04-17 21:45:10"
                updated_at: "2014-04-17 22:38:02"
                lat: 0
                lng: 0
                skills: [
                    {
                        id: 6
                        name: "Consequatur est cumque."
                        active: 1
                        category_id: 4
                        deleted_at: null
                        created_at: "2014-04-18 01:58:29"
                        updated_at: "2014-04-18 01:58:29"
                        pivot: {
                            job_id: 162
                            skill_id: 6
                        }
                    }
                ]
            }
        ]
        
### Auth:JobPoster | Add Job [POST]

+ Request (application/x-www-form-urlencoded)

    + Headers
    
            +X-Auth-Token:{token}

    + Body

            title = 
            description =
            address1 = 
            city = 
            state = 
            max_payrate = 
            contact_email = 
            skills[] =

+ Response 201 (application/json)

        {
            "id":173,
            "posted_by":17,
            "title":"Tell her to carry it further. So she swallowed one of the other side",
            "description":"Alice's great surprise",
            "max_payrate":97,
            "contact_phone":"",
            "contact_email":"",
            "location":null,
            "address1":"88527 Amya Via Apt. 216",
            "city":"West Princeburgh",
            "state":"KY",
            "zip":"81619",
            "date_closed":"2013-12-14 17:26:04",
            "active":0,
            "reported":0,
            "deleted_at":null,
            "created_at":"2013-11-23 17:26:04",
            "updated_at":"2013-12-09 21:16:12",
            "lat":0,
            "lng":0,
            "skills":[
                {
                    "id":29,
                    "name":"Quia repellendus.",
                    "active":1,
                    "category_id":1,
                    "deleted_at":null,
                    "created_at":"2014-04-18 01:58:30",
                    "updated_at":"2014-04-18 01:58:30",
                    "pivot":{
                        "job_id":173,
                        "skill_id":29
                    }            
                }
            ]
        }

## Job Resource [/jobs/{id}]
The below calls can only be executed by the User who posted the Job or a site Admin

### Auth:JobPoster | Edit Job [PUT]

+ Parameters
    + id (required, integer, `1`) ... Numeric `id` of the Job to edit

+ Request (application/x-www-form-urlencoded)

    + Headers
    
            +X-Auth-Token:{token}

    + Body

            title = 
            description =
            address1 = 
            city = 
            state = 
            max_payrate = 
            contact_email = 
            skills[] =

+ Response 201 (application/json)

        {
            "id":173,
            "posted_by":17,
            "title":"Tell her to carry it further. So she swallowed one of the other side",
            "description":"Alice's great surprise",
            "max_payrate":97,
            "contact_phone":"",
            "contact_email":"",
            "location":null,
            "address1":"88527 Amya Via Apt. 216",
            "city":"West Princeburgh",
            "state":"KY",
            "zip":"81619",
            "date_closed":"2013-12-14 17:26:04",
            "active":0,
            "reported":0,
            "deleted_at":null,
            "created_at":"2013-11-23 17:26:04",
            "updated_at":"2013-12-09 21:16:12",
            "lat":0,
            "lng":0,
            "skills":[
                {
                    "id":29,
                    "name":"Quia repellendus.",
                    "active":1,
                    "category_id":1,
                    "deleted_at":null,
                    "created_at":"2014-04-18 01:58:30",
                    "updated_at":"2014-04-18 01:58:30",
                    "pivot":{
                        "job_id":173,
                        "skill_id":29
                    }            
                }
            ]
        }
        
### Auth:JobPoster | Delete Job [DELETE]

+ Parameters
    + id (required, integer, `1`) ... Numeric `id` of the Job to delete
    
+ Response 204