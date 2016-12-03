# people-manager
A flat PHP application to manager people. 

# Database 
```sql
CREATE TABLE people
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL
);
```
