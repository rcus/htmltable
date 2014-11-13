<?php
// Drop a table if it exists
$table->dropTableIfExists('test')
   ->execute();

// Create a table
$table->createTable(
    'test',
    [
        'id'        => ['integer', 'auto_increment', 'primary key', 'not null'],
        'firstname' => ['varchar(20)'],
        'surname'   => ['varchar(20)'],
        'birthdate' => ['date']
    ]
);
$table->execute();

// Rows to test with
$rows = [
    ['Mohamed', 'Holmqvist', '1981-01-15'], ['Magnus', 'Lindholm', '1971-01-22'], ['Felicia', 'Sandström', '1988-08-04'], ['Stefan', 'Wallin', '1987-04-02'], ['Karin', 'Björk', '2001-01-23'], ['Daniel', 'Johansson', '1979-07-10'], ['Adam', 'Bergqvist', '2004-08-24'], ['Kenneth', 'Wikström', '1999-02-03'], ['John', 'Pettersson', '1976-11-25'], ['Louise', 'Abrahamsson', '1981-07-13'], ['Gun', 'Arvidsson', '1976-03-29'], ['Roland', 'Lind', '1987-03-19'], ['Peter', 'Berggren', '2004-03-05'], ['Thomas', 'Andersson', '1974-04-18'], ['Britta', 'Ekström', '1975-04-16'], ['Caroline', 'Jönsson', '1981-10-02'], ['Sven', 'Lundström', '1983-12-29'], ['Alexandra', 'Göransson', '2001-01-10'], ['Kerstin', 'Söderberg', '1993-02-02'], ['Lennart', 'Sandberg', '2002-12-11'], ['Kurt', 'Norberg', '1981-10-10'], ['Annika', 'Gustafsson', '1991-04-17'], ['Julia', 'Samuelsson', '2001-05-20'], ['Madeleine', 'Svensson', '1991-06-15'], ['Irene', 'Blom', '1993-02-18'], ['Linus', 'Sundqvist', '2002-11-07'], ['Elias', 'Viklund', '1978-02-24'], ['Jessica', 'Nordin', '2000-11-17'], ['Lena', 'Holmgren', '2004-12-02'], ['Sten', 'Josefsson', '1994-05-25'], ['Joel', 'Ali', '1986-01-06'], ['Roger', 'Martinsson', '1986-02-03'], ['Josefin', 'Lund', '1992-10-27'], ['Malin', 'Lundqvist', '1978-05-01'], ['Kent', 'Larsson', '1988-11-09'], ['Patrik', 'Mattsson', '2000-06-02'], ['Göran', 'Lindberg', '1974-08-01'], ['Axel', 'Håkansson', '2009-05-18'], ['Emelie', 'Ek', '2007-12-02'], ['Johnny', 'Hansson', '2001-08-05'], ['Viktoria', 'Sundström', '1986-05-16'], ['Per', 'Ström', '2008-10-03'], ['Samuel', 'Eliasson', '2002-08-01'], ['Jonas', 'Sjöberg', '2004-10-23'], ['Ulla', 'Löfgren', '1994-09-13'], ['Dan', 'Olofsson', '1976-08-16'], ['Helena', 'Berglund', '2004-04-20'], ['Matilda', 'Lindqvist', '2009-03-10'], ['Inga', 'Olsson', '1979-11-22'], ['Gunnar', 'Månsson', '2007-12-28'], ['Kevin', 'Dahlberg', '1990-02-25'], ['Johanna', 'Nyström', '1998-05-27'], ['Margareta', 'Persson', '2001-10-24'], ['Ellen', 'Holm', '1978-07-21'], ['Olof', 'Bergman', '1990-04-18'], ['Filip', 'Axelsson', '2001-04-12'], ['Mona', 'Blomqvist', '1996-09-24'], ['Linnéa', 'Strömberg', '1982-12-07'], ['Oskar', 'Mårtensson', '1993-11-19'], ['Jan', 'Åström', '1972-06-09'], ['Eva', 'Bengtsson', '1988-08-29'], ['Jimmy', 'Magnusson', '1994-01-28'], ['Hanna', 'Danielsson', '1985-09-17'], ['Albin', 'Sundberg', '1988-07-22'], ['Britt', 'Ivarsson', '1971-09-17'], ['Ann-Christin', 'Hansen', '2008-12-05'], ['Mats', 'Jakobsson', '1981-01-15'], ['Mikael', 'Lindgren', '1972-09-17'], ['Hans', 'Lundgren', '1983-08-27'], ['Marie', 'Eriksson', '1995-11-15'], ['Inger', 'Fredriksson', '1976-07-07'], ['Kjell', 'Eklund', '2009-08-03'], ['Susanne', 'Pålsson', '1994-01-06'], ['Jonathan', 'Jonasson', '2004-03-29'], ['Britt-Marie', 'Börjesson', '1997-01-15'], ['Jenny', 'Hellström', '2007-06-24'], ['Torbjörn', 'Mohamed', '1975-11-03'], ['Martin', 'Nilsson', '1972-09-21'], ['Amanda', 'Claesson', '2004-10-05'], ['Anette', 'Öberg', '1970-12-16'], ['Moa', 'Andreasson', '1978-06-26'], ['Lisa', 'Falk', '1980-08-01'], ['Bertil', 'Henriksson', '2009-11-24'], ['Emil', 'Berg', '1986-08-17'], ['Leif', 'Björklund', '2000-04-10'], ['Ella', 'Åkesson', '1997-04-17'], ['Ulf', 'Jonsson', '1977-03-20'], ['Isabelle', 'Hedlund', '1988-05-23'], ['Maria', 'Sjögren', '1981-01-28'], ['Dennis', 'Lundberg', '1993-05-26'], ['Ingrid', 'Lundin', '1989-02-27'], ['Rebecka', 'Bergström', '1994-12-19'], ['Lisbeth', 'Söderström', '1984-11-01'], ['Marianne', 'Fransson', '1974-09-01'], ['Rasmus', 'Hermansson', '1998-11-11'], ['Alexander', 'Nordström', '1987-09-07'], ['Arne', 'Jansson', '1981-07-08'], ['William', 'Gunnarsson', '2004-04-19'], ['Astrid', 'Engström', '1984-03-11'], ['Robin', 'Nyberg', '2000-06-15']
];

// Insert rows
$table->insert(
    'test',
    ['firstname', 'surname', 'birthdate']
);
foreach ($rows as $row) {
    $table->execute($row);
}
