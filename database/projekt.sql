-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 30 Lis 2017, 21:59
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
-- Baza danych: `projekt`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `accounts`
--

CREATE TABLE `Accounts` (
  `Account_ID` int(11) NOT NULL,
  `Account_Status_Code` int(11) NOT NULL,
  `Customer_ID` int(11) NOT NULL,
  `Current_Balance` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `addresses`
--

CREATE TABLE `Addresses` (
  `Address_ID` int(11) NOT NULL,
  `Line_1` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Line_2` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Town_City` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Zip-Postcode` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `State_Province_County` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Country` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `banks`
--

CREATE TABLE `Banks` (
  `Bank_ID` int(11) NOT NULL,
  `Bank_Details` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `branches`
--

CREATE TABLE `Branches` (
  `Branch_ID` int(11) NOT NULL,
  `Address_ID` int(11) NOT NULL,
  `Bank_ID` int(11) NOT NULL,
  `Branch_Type_Code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `customers`
--

CREATE TABLE `Customers` (
  `Customer_ID` int(11) NOT NULL,
  `Address_ID` int(11) NOT NULL,
  `Branch_ID` int(11) NOT NULL,
  `Name` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Surname` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `User` text NOT NULL,
  `Password` text NOT NULL,
  `Email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ref_account_status`
--

CREATE TABLE `Ref_account_status` (
  `Account_Status_Code` int(11) NOT NULL,
  `Account_Status_Description` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ref_branch_types`
--

CREATE TABLE `Ref_branch_types` (
  `Branch_Type_Code` int(11) NOT NULL,
  `Branch_Type_Description` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ref_transaction_type`
--

CREATE TABLE `Ref_transaction_type` (
  `Transaction_Type_Code` int(11) NOT NULL,
  `Transaction_Type_Description` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `transactions`
--

CREATE TABLE `Transactions` (
  `Transaction_ID` int(11) NOT NULL,
  `Account_ID` int(11) NOT NULL,
  `Customer_ID` int(11) NOT NULL,
  `Transaction_Type_Code` int(11) NOT NULL,
  `Transaction_Date_Time` datetime DEFAULT NULL,
  `Transaction_Amount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `Accounts`
  ADD PRIMARY KEY (`Account_ID`),
  ADD KEY `Accounts_fk0` (`Account_Status_Code`),
  ADD KEY `Accounts_fk1` (`Customer_ID`);

--
-- Indexes for table `addresses`
--
ALTER TABLE `Addresses`
  ADD PRIMARY KEY (`Address_ID`);

--
-- Indexes for table `banks`
--
ALTER TABLE `Banks`
  ADD PRIMARY KEY (`Bank_ID`);

--
-- Indexes for table `branches`
--
ALTER TABLE `Branches`
  ADD PRIMARY KEY (`Branch_ID`),
  ADD KEY `Branches_fk0` (`Address_ID`),
  ADD KEY `Branches_fk1` (`Bank_ID`),
  ADD KEY `Branches_fk2` (`Branch_Type_Code`);

--
-- Indexes for table `customers`
--
ALTER TABLE `Customers`
  ADD PRIMARY KEY (`Customer_ID`),
  ADD KEY `Customers_fk0` (`Address_ID`),
  ADD KEY `Customers_fk1` (`Branch_ID`);

--
-- Indexes for table `ref_account_status`
--
ALTER TABLE `Ref_account_status`
  ADD PRIMARY KEY (`Account_Status_Code`);

--
-- Indexes for table `ref_branch_types`
--
ALTER TABLE `Ref_branch_types`
  ADD PRIMARY KEY (`Branch_Type_Code`);

--
-- Indexes for table `ref_transaction_type`
--
ALTER TABLE `Ref_transaction_type`
  ADD PRIMARY KEY (`Transaction_Type_Code`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `Transactions`
  ADD PRIMARY KEY (`Transaction_ID`),
  ADD KEY `Transactions_fk0` (`Account_ID`),
  ADD KEY `Transactions_fk1` (`Customer_ID`),
  ADD KEY `Transactions_fk2` (`Transaction_Type_Code`);

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `accounts`
--
ALTER TABLE `Accounts`
  ADD CONSTRAINT `Accounts_fk0` FOREIGN KEY (`Account_Status_Code`) REFERENCES `ref_account_status` (`Account_Status_Code`),
  ADD CONSTRAINT `Accounts_fk1` FOREIGN KEY (`Customer_ID`) REFERENCES `customers` (`Customer_ID`);

--
-- Ograniczenia dla tabeli `branches`
--
ALTER TABLE `Branches`
  ADD CONSTRAINT `Branches_fk0` FOREIGN KEY (`Address_ID`) REFERENCES `addresses` (`Address_ID`),
  ADD CONSTRAINT `Branches_fk1` FOREIGN KEY (`Bank_ID`) REFERENCES `banks` (`Bank_ID`),
  ADD CONSTRAINT `Branches_fk2` FOREIGN KEY (`Branch_Type_Code`) REFERENCES `ref_branch_types` (`Branch_Type_Code`);

--
-- Ograniczenia dla tabeli `transactions`
--
ALTER TABLE `Transactions`
  ADD CONSTRAINT `Transactions_fk0` FOREIGN KEY (`Account_ID`) REFERENCES `accounts` (`Account_ID`),
  ADD CONSTRAINT `Transactions_fk1` FOREIGN KEY (`Customer_ID`) REFERENCES `customers` (`Customer_ID`),
  ADD CONSTRAINT `Transactions_fk2` FOREIGN KEY (`Transaction_Type_Code`) REFERENCES `ref_transaction_type` (`Transaction_Type_Code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
