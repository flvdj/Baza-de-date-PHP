# Baza-de-date-PHP
# Aplicație Web - Gestionare Călători și Sucursale CFR

## Descriere
Acest proiect reprezintă o aplicație web dezvoltată folosind PHP și MySQL, având ca scop gestionarea unei baze de date pentru călători și sucursale CFR. Aplicația permite efectuarea operațiilor CRUD (Creare, Citire, Actualizare, Ștergere) asupra tabelelor și gestionează o relație de tip M:N între „Travellers” și „BranchCFR” prin intermediul tabelei intermediare „Journey”.

## Tehnologii utilizate
- **PHP** - Limbaj de programare server-side utilizat pentru procesarea datelor.
- **MySQL** - Sistem de gestionare a bazelor de date relaționale.
- **Apache Tomcat / XAMPP** - Server de aplicații pentru rularea codului PHP.
- **HTML / CSS** - Crearea interfeței utilizatorului pentru interacțiunea cu baza de date.

## Structura bazei de date
- **Travellers** (id, nume, email, telefon, etc.)
- **BranchCFR** (id, denumire, locație, etc.)
- **Journey** (id, id_traveller, id_branchcfr, data_călătoriei)

Relațiile dintre tabele:
- Între „Travellers” și „BranchCFR” există o relație M:N prin tabela „Journey”.
- Între „Travellers” și „Journey” există o relație 1:N.
- Între „BranchCFR” și „Journey” există o relație 1:N.

## Funcționalități implementate
1. **Conectarea la baza de date** folosind PHP și XAMPP.
2. **Operații CRUD** pentru toate tabelele.
3. **Interfață HTML interactivă**, cu butoane pentru gestionarea datelor.
4. **Gestionarea excepțiilor** pentru prevenirea erorilor de introducere a datelor.

## Instalare și utilizare
1. **Clonați repository-ul** în local:
   ```bash
   git clone https://github.com/username/repository.git
   ```
2. **Configurați baza de date MySQL** utilizând scriptul SQL furnizat.
3. **Porniți XAMPP** și asigurați-vă că serverul Apache și MySQL sunt active.
4. **Accesați interfața aplicației** prin browser, navigând la:
   ```
   http://localhost/numele_aplicatiei
   ```



## Autori
- **Student:** Nistor Flaviu-Cristian (431D)
- **Coordonator:** Ș.l. Dr. Ing. Pupezescu Valentin

## Licență
Acest proiect a fost realizat în cadrul Universității Naționale de Știință și Tehnologie Politehnica București, Facultatea de Electronică, Telecomunicații și Tehnologia Informației, 2025.


