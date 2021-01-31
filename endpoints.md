# API RESTAURANT


### **BD**
- Reservas
    - id (PK)
    - pers
    - nom
    - tel
    - dia
    - hora
    - taules
    - sala (FK)
    - email
    - coment
- Sales
    - id(PK)
    - nom
- Usuaris
    - id (PK)
    - nom
    - cognoms
    - email
    - pwd
    - tel
    - actiu


### **ENDPOINTS**
|mrthod|endpoint|
|:--|:--|
|GET|**/sales**|
|GET|**/reserves**|
|GET|**/reserva/{id}**|
|POST|**/reserva/create**|
|PATCH|**/reserva/{id}/update**|
|DELETE|**/reserva/{id}/delete**|
|GET|**/usuaris**|
|GET|**/usuari/{id}**|
|POST|**/usuari/create**|
|PATCH|**/usuari/{id}/update**|
|DELETE|**/usuari/{id}/delete**|
|POST|**/usuari/{id,pwd}/login**|