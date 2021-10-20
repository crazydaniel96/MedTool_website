# Medical Office Management tool
This website is built using `HTML`, `JavaScript` and `PHP`, database is not provided.   

## Login and Logout
Users can access the private area with different privileges:
 * **Specialist**: free access to all functionalities;
 * **Temporary worker**: can only create/edit/delete an appointment.  
## Schedule of working hours
*work in progress*
## Current Working Day
*work in progress*
## Edit a date  
*work in progress*
## Database structure 
Database structure is shown above: 

    Database 
      |-- accounts
      |   |-- id
      |   |-- username
      |   |-- password
      |   `-- restricted
      |-- bookings
      |   |-- id
      |   |-- Surname
      |   |-- Name
      |   |-- Visit_Date
      |   |-- Visit_hour
      |   |-- Phone
      |   |-- DayBorn
      |   |-- CityBorn
      |   |-- CityNow
      |   |-- Address
      |   |-- Notes
      |   `-- Result
      |-- calendar
      |   |-- Day
      |   |-- name
      |   |-- VisitSpan
      |   |-- booked
      |   `-- private
      |-- history
      |   |-- id
      |   |-- Name
      |   |-- Surname
      |   |-- Date
      |   |-- Category
      |   `-- Report
      `-- reports
          |-- id
          |-- Category
          |-- Title
          |-- Body
          `-- header
