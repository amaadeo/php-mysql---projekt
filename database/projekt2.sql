-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 08 Sty 2018, 00:10
-- Wersja serwera: 10.1.28-MariaDB
-- Wersja PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `projekt2`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `accounts`
--

CREATE TABLE `accounts` (
  `Account_ID` int(11) NOT NULL,
  `Account_Status_ID` int(11) NOT NULL DEFAULT '1',
  `Customer_ID` int(11) NOT NULL,
  `Login` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Account_Number` bigint(9) NOT NULL,
  `Current_Ballance` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `accounts`
--

INSERT INTO `accounts` (`Account_ID`, `Account_Status_ID`, `Customer_ID`, `Login`, `Password`, `Email`, `Account_Number`, `Current_Ballance`) VALUES
(1, 1, 1, 'admin', '$2y$10$UfaPZKOKUmS95toXIbJLPeuvN7fznu2pnlQKL/YdRyOOSB44Db9Ye', 'admin@wp.pl', 485513981, 1000),
(2, 1, 2, 'amadeo', '$2y$10$UzZDtCRzS5z3d/aenH67GOW78VPqbVVz4r9xVTTNkNAGks3qSSjuq', 'ama5@poczta.onet.pl', 828655111, 1000);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `account_status`
--

CREATE TABLE `account_status` (
  `Account_Status_ID` int(11) NOT NULL,
  `Account_Status_Description` varchar(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `account_status`
--

INSERT INTO `account_status` (`Account_Status_ID`, `Account_Status_Description`) VALUES
(0, 'Zamknięte'),
(1, 'Otwarte');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `addresses`
--

CREATE TABLE `addresses` (
  `Address_ID` int(11) NOT NULL,
  `Street` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `City` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Postcode` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Province` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Country` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Polska'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `addresses`
--

INSERT INTO `addresses` (`Address_ID`, `Street`, `City`, `Postcode`, `Province`, `Country`) VALUES
(1, 'ul. Aleja Kościuszki 15', 'Łódź', '90-959', 'łódzkie', 'Polska'),
(2, 'ul. Admin 12', 'Admin', '78-897', 'adminowe', 'Polska'),
(3, 'ul. Osiedle Wyzwolenia 17/67', 'Turek', '62-700', 'wielkopolskie', 'Polska');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `banks`
--

CREATE TABLE `banks` (
  `Bank_ID` int(11) NOT NULL,
  `Bank_Details` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `banks`
--

INSERT INTO `banks` (`Bank_ID`, `Bank_Details`) VALUES
(1, 'PKO BP'),
(2, 'M Bank');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `branches`
--

CREATE TABLE `branches` (
  `Branch_ID` int(11) NOT NULL,
  `Address_ID` int(11) NOT NULL,
  `Bank_ID` int(11) NOT NULL,
  `Branch_Type_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `branches`
--

INSERT INTO `branches` (`Branch_ID`, `Address_ID`, `Bank_ID`, `Branch_Type_ID`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `branches_type`
--

CREATE TABLE `branches_type` (
  `Branch_Type_ID` int(11) NOT NULL,
  `Branch_Type_Description` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `branches_type`
--

INSERT INTO `branches_type` (`Branch_Type_ID`, `Branch_Type_Description`) VALUES
(1, 'Oddział 1');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `customers`
--

CREATE TABLE `customers` (
  `Customer_ID` int(11) NOT NULL,
  `Address_ID` int(11) NOT NULL,
  `Branch_ID` int(11) NOT NULL,
  `Name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `PESEL` bigint(11) NOT NULL,
  `Telephone` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `customers`
--

INSERT INTO `customers` (`Customer_ID`, `Address_ID`, `Branch_ID`, `Name`, `PESEL`, `Telephone`) VALUES
(1, 2, 1, 'Admin Strony', 12345678912, 123456789),
(2, 3, 1, 'Amadeusz Janiak', 96060501036, 725376735);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `transactions`
--

CREATE TABLE `transactions` (
  `Transaction_ID` int(11) NOT NULL,
  `Account_ID` int(11) NOT NULL COMMENT 'Skąd przelew?',
  `Customer_ID` int(11) NOT NULL COMMENT 'Do kogo przelew?',
  `Transaction_Type_ID` int(11) NOT NULL,
  `Transaction_Datetime` datetime NOT NULL,
  `Transaction_Amount` float NOT NULL,
  `Transaction_Title` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `Account_Ballance_Before` float NOT NULL,
  `Account_Ballance_After` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `transactions`
--

INSERT INTO `transactions` (`Transaction_ID`, `Account_ID`, `Customer_ID`, `Transaction_Type_ID`, `Transaction_Datetime`, `Transaction_Amount`, `Transaction_Title`, `Account_Ballance_Before`, `Account_Ballance_After`) VALUES
(1, 2, 1, 2, '2018-01-08 00:03:39', 100, 'pierwszy przelew', 1000, 900),
(2, 1, 2, 2, '2018-01-08 00:05:35', 100, 'oddaje stowke', 1100, 1000),
(3, 2, 2, 0, '2018-01-09 00:11:00', 750, 'wpłata pieniędzy', 1000, 1750),
(4, 2, 2, 1, '2018-01-09 00:12:00', 50, 'wypłata', 1750, 1700);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `transaction_type`
--

CREATE TABLE `transaction_type` (
  `Transaction_Type_ID` int(11) NOT NULL,
  `Transaction_Type_Description` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `transaction_type`
--

INSERT INTO `transaction_type` (`Transaction_Type_ID`, `Transaction_Type_Description`) VALUES
(0, 'Wpłata'),
(1, 'Wypłata'),
(2, 'Przelew');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`Account_ID`),
  ADD KEY `Account_Status-fk1` (`Account_Status_ID`),
  ADD KEY `Customer-fk3` (`Customer_ID`);

--
-- Indexes for table `account_status`
--
ALTER TABLE `account_status`
  ADD PRIMARY KEY (`Account_Status_ID`);

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`Address_ID`),
  ADD UNIQUE KEY `Address_ID` (`Address_ID`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`Bank_ID`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`Branch_ID`),
  ADD KEY `Bank_ID` (`Bank_ID`),
  ADD KEY `Address-fk` (`Address_ID`),
  ADD KEY `Branch_type-fk` (`Branch_Type_ID`);

--
-- Indexes for table `branches_type`
--
ALTER TABLE `branches_type`
  ADD PRIMARY KEY (`Branch_Type_ID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`Customer_ID`),
  ADD KEY `Address-fk2` (`Address_ID`),
  ADD KEY `Bank-fk1` (`Branch_ID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`Transaction_ID`),
  ADD KEY `Account-fk11` (`Account_ID`),
  ADD KEY `Customer-fk33` (`Customer_ID`),
  ADD KEY `Transaction_Type-fk` (`Transaction_Type_ID`);

--
-- Indexes for table `transaction_type`
--
ALTER TABLE `transaction_type`
  ADD PRIMARY KEY (`Transaction_Type_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `accounts`
--
ALTER TABLE `accounts`
  MODIFY `Account_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `addresses`
--
ALTER TABLE `addresses`
  MODIFY `Address_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `customers`
--
ALTER TABLE `customers`
  MODIFY `Customer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `transactions`
--
ALTER TABLE `transactions`
  MODIFY `Transaction_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `Account_Status-fk1` FOREIGN KEY (`Account_Status_ID`) REFERENCES `account_status` (`Account_Status_ID`),
  ADD CONSTRAINT `Customer-fk3` FOREIGN KEY (`Customer_ID`) REFERENCES `customers` (`Customer_ID`);

--
-- Ograniczenia dla tabeli `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `Address-fk` FOREIGN KEY (`Address_ID`) REFERENCES `addresses` (`Address_ID`),
  ADD CONSTRAINT `Bank-fk` FOREIGN KEY (`Bank_ID`) REFERENCES `banks` (`Bank_ID`),
  ADD CONSTRAINT `Branch_type-fk` FOREIGN KEY (`Branch_Type_ID`) REFERENCES `branches_type` (`Branch_Type_ID`);

--
-- Ograniczenia dla tabeli `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `Address-fk2` FOREIGN KEY (`Address_ID`) REFERENCES `addresses` (`Address_ID`),
  ADD CONSTRAINT `Bank-fk1` FOREIGN KEY (`Branch_ID`) REFERENCES `branches` (`Branch_ID`);

--
-- Ograniczenia dla tabeli `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `Account-fk11` FOREIGN KEY (`Account_ID`) REFERENCES `accounts` (`Account_ID`),
  ADD CONSTRAINT `Customer-fk33` FOREIGN KEY (`Customer_ID`) REFERENCES `customers` (`Customer_ID`),
  ADD CONSTRAINT `Transaction_Type-fk` FOREIGN KEY (`Transaction_Type_ID`) REFERENCES `transaction_type` (`Transaction_Type_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
