# API RESTAURANT

### **BD**

- Reservas
  - id (PK)
  - pers
  - dia
  - hora
  - taules
  - sala (FK)
  - estat
  - nom
  - tel
  - email
  - coment
- Sales
  - id(PK)
  - nom
  - taules
- Usuaris
  - id (PK)
  - nom
  - cognoms
  - email
  - pwd
  - tel
  - actiu

### **ENDPOINTS**

| mrthod | endpoint          |
| :----- | :---------------- |
| GET    | **/sales**        |
| GET    | **/reserves**     |
| GET    | **/reserva/{id}** |
| POST   | **/reserva/new**  |
| POST   | **/ocupades**     |
| POST   | **/reserva/mail** |
