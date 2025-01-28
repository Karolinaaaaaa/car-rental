# Wypożyczalnia Samochodów

Projekt aplikacji frontendowo-backendowej do zarządzania bazą danych pojazdów w wypożyczalni samochodowej.

---

## **Wymagania**

- **Docker** i **Docker Compose**
- **Node.js** (wersja 14 lub wyższa)
- **Angular CLI** (dla części frontendowej)
- **PHP** 8.1 lub wyższy (jeśli nie korzystasz z Dockera)

---

## **Uruchamianie aplikacji**

1. Przejdź do katalogu backend:

   ```bash
   cd backend
   ```

2. Zainstaluj composer:

   ```bash
   composer install
   ```

### **Backend**

1. Uruchom Dockera:
   w głównym katalogu aplikacji wykonaj:

   ```bash
   docker-compose up --build
   ```

2. Wykonaj migracje bazy danych:

   ```bash
   docker exec -it car_rental_backend php bin/console doctrine:migrations:migrate
   ```

3. Backend powinien być dostępny pod: [http://localhost:8000](http://localhost:8000).

---

### **Frontend**

1. Frontend będzie dostępny pod: [http://localhost:4200](http://localhost:4200).

---

## **Swagger**

1. Specyfikacja API jest dostępna pod adresem:

   - [http://localhost:8000/api/doc](http://localhost:8000/api/doc)

2. Obsługuje metody `GET`, `POST`, `PUT`, `DELETE`.

---

## **Funkcjonalności**

### **Frontend:**

- Lista pojazdów:
  - Wyświetlanie danych pojazdu.
  - Usuwanie z potwierdzeniem.
  - Edycja i dodawanie pojazdu.
  - Obsługa błędów połączenia (np. przy braku internetu).
- Formularz dodawania/edycji pojazdu:
  - Walidacja pól z komunikatami błędów.
  - Adres jako osobny komponent.
- Responsywność i stylizacja z AngularJS Material.

### **Backend:**

- Obsługa CRUD dla pojazdów.
- Walidacja danych wejściowych z formularzy.
- Generowanie API dokumentacji za pomocą Swagger.

---
