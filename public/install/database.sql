-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2021 at 12:53 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cc_hyiplab`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `email_verified_at`, `image`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Supper Admin', 'viserlab@gmail.com', 'admin', NULL, '5eea09e65cefb1592396262.jpg', '$2y$10$nZwHEGoPXQ6PG5VH/A6dDOgW.c2bkcoLmvOAbc62H8gWllZ/ZBegK', NULL, '2020-07-25 01:35:29');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `read_status` tinyint(4) NOT NULL DEFAULT 0,
  `click_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commission_logs`
--

CREATE TABLE `commission_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_id` int(11) DEFAULT NULL,
  `to_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `commission_amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `main_amo` decimal(18,8) DEFAULT 0.00000000,
  `trx_amo` decimal(18,8) NOT NULL DEFAULT 0.00000000 COMMENT 'Transacted Amount',
  `percent` decimal(11,2) NOT NULL DEFAULT 0.00,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `method_code` int(10) UNSIGNED NOT NULL,
  `amount` decimal(18,8) NOT NULL,
  `method_currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `charge` decimal(18,8) NOT NULL,
  `rate` decimal(18,8) NOT NULL,
  `final_amo` decimal(18,8) DEFAULT 0.00000000,
  `detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_amo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_wallet` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `try` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel',
  `admin_feedback` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_logs`
--

CREATE TABLE `email_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `mail_sender` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_logs`
--

INSERT INTO `email_logs` (`id`, `user_id`, `mail_sender`, `from`, `to`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 1, 'php', 'HYIPLab do-not-reply@email.com', 'user@site.com', 'Deposit Completed Successfully', '<table style=\"color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(0, 23, 54); text-decoration-style: initial; text-decoration-color: initial;\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" bgcolor=\"#001736\"><tbody><tr><td valign=\"top\" align=\"center\"><table class=\"mobile-shell\" width=\"650\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"td container\" style=\"width: 650px; min-width: 650px; font-size: 0pt; line-height: 0pt; margin: 0px; font-weight: normal; padding: 55px 0px;\"><div style=\"text-align: center;\"><img src=\"https://i.imgur.com/C9IS7Z1.png\" style=\"height: 240 !important;width: 338px;margin-bottom: 20px;\"></div><table style=\"width: 650px; margin: 0px auto;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td style=\"padding-bottom: 10px;\"><table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"tbrr p30-15\" style=\"padding: 60px 30px; border-radius: 26px 26px 0px 0px;\" bgcolor=\"#000036\"><table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td style=\"color: rgb(255, 255, 255); font-family: Muli, Arial, sans-serif; font-size: 20px; line-height: 46px; padding-bottom: 25px; font-weight: bold;\">Hi username ,</td></tr><tr><td style=\"color: rgb(193, 205, 220); font-family: Muli, Arial, sans-serif; font-size: 20px; line-height: 30px; padding-bottom: 25px;\"><div>Your deposit of <b>100 USD</b> is via&nbsp; <b>Stripe Storefront - USD </b>has been completed Successfully.<b><br></b></div><div><b><br></b></div><div><b>Details of your Deposit :<br></b></div><div><br></div><div>Amount : 100 USD</div><div>Charge: <font color=\"#000000\">3 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 1 USD</div><div>Payable : 103 USD <br></div><div>Paid via :&nbsp; Stripe Storefront - USD</div><div><br></div><div>Transaction Number : 851KSCNW6G7D</div><div><font size=\"5\"><b><br></b></font></div><div><font size=\"5\">Your current Balance is <b>2910 USD</b></font></div><div><br></div><div><br><br><br></div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style=\"width: 650px; margin: 0px auto;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"p30-15 bbrr\" style=\"padding: 50px 30px; border-radius: 0px 0px 26px 26px;\" bgcolor=\"#000036\"><table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"text-footer1 pb10\" style=\"color: rgb(0, 153, 255); font-family: Muli, Arial, sans-serif; font-size: 18px; line-height: 30px; text-align: center; padding-bottom: 10px;\">© 2020 ViserLab. All Rights Reserved.</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>', '2021-05-29 09:38:39', '2021-05-29 09:38:39');

-- --------------------------------------------------------

--
-- Table structure for table `email_sms_templates`
--

CREATE TABLE `email_sms_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `act` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subj` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortcodes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_status` tinyint(4) NOT NULL DEFAULT 1,
  `sms_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_sms_templates`
--

INSERT INTO `email_sms_templates` (`id`, `act`, `name`, `subj`, `email_body`, `sms_body`, `shortcodes`, `email_status`, `sms_status`, `created_at`, `updated_at`) VALUES
(1, 'PASS_RESET_CODE', 'Password Reset', 'Password Reset', '<div>We have received a request to reset the password for your account on <b>{{time}} .<br></b></div><div>Requested From IP: <b>{{ip}}</b> using <b>{{browser}}</b> on <b>{{operating_system}} </b>.</div><div><br></div><br><div><div><div>Your account recovery code is:&nbsp;&nbsp; <font size=\"6\"><b>{{code}}</b></font></div><div><br></div></div></div><div><br></div><div><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><br>', 'Your account recovery code is: {{code}}', ' {\"code\":\"Password Reset Code\",\"ip\":\"IP of User\",\"browser\":\"Browser of User\",\"operating_system\":\"Operating System of User\",\"time\":\"Request Time\"}', 1, 1, '2019-09-24 23:04:05', '2020-07-07 05:44:08'),
(2, 'PASS_RESET_DONE', 'Password Reset Confirmation', 'You have Reset your password', '<div><p>\r\n    You have successfully reset your password.</p><p>You changed from&nbsp; IP: <b>{{ip}}</b> using <b>{{browser}}</b> on <b>{{operating_system}}&nbsp;</b> on <b>{{time}}</b></p><p><b><br></b></p><p><font color=\"#FF0000\"><b>If you did not changed that, Please contact with us as soon as possible.</b></font><br></p></div>', 'Your password has been changed successfully', '{\"ip\":\"IP of User\",\"browser\":\"Browser of User\",\"operating_system\":\"Operating System of User\",\"time\":\"Request Time\"}', 1, 1, '2019-09-24 23:04:05', '2020-03-07 10:23:47'),
(3, 'EVER_CODE', 'Email Verification', 'Please verify your email address', '<div><br></div><div>Thanks For join with us. <br></div><div>Please use below code to verify your email address. <br></div><div><br></div><div>Your email verification code is:<font size=\"6\"><b> {{code}}</b></font></div>', 'Your email verification code is: {{code}}', '{\"code\":\"Verification code\"}', 1, 1, '2019-09-24 23:04:05', '2020-03-07 10:26:22'),
(4, 'SVER_CODE', 'SMS Verification ', 'Please verify your phone', 'Your phone verification code is: {{code}}', 'Your phone verification code is: {{code}}', '{\"code\":\"Verification code\"}', 0, 1, '2019-09-24 23:04:05', '2020-03-08 01:28:52'),
(5, '2FA_ENABLE', 'Google Two Factor - Enable', 'Google Two Factor Authentication is now  Enabled for Your Account', '<div>You just enabled Google Two Factor Authentication for Your Account.</div><div><br></div><div>Enabled at <b>{{time}} </b>From IP: <b>{{ip}}</b> using <b>{{browser}}</b> on <b>{{operating_system}} </b>.</div>', 'Your verification code is: {{code}}', '{\"ip\":\"IP of User\",\"browser\":\"Browser of User\",\"operating_system\":\"Operating System of User\",\"time\":\"Request Time\"}', 1, 1, '2019-09-24 23:04:05', '2020-03-08 01:42:59'),
(6, '2FA_DISABLE', 'Google Two Factor Disable', 'Google Two Factor Authentication is now  Disabled for Your Account', '<div>You just Disabled Google Two Factor Authentication for Your Account.</div><div><br></div><div>Disabled at <b>{{time}} </b>From IP: <b>{{ip}}</b> using <b>{{browser}}</b> on <b>{{operating_system}} </b>.</div>', 'Google two factor verification is disabled', '{\"ip\":\"IP of User\",\"browser\":\"Browser of User\",\"operating_system\":\"Operating System of User\",\"time\":\"Request Time\"}', 1, 1, '2019-09-24 23:04:05', '2020-03-08 01:43:46'),
(7, 'ADMIN_SUPPORT_REPLY', 'Support Ticket Reply ', 'Reply Support Ticket', '<div><p><span style=\"font-size: 11pt;\" data-mce-style=\"font-size: 11pt;\"><strong>A member from our support team has replied to the following ticket:</strong></span></p><p><b><span style=\"font-size: 11pt;\" data-mce-style=\"font-size: 11pt;\"><strong><br></strong></span></b></p><p><b>[Ticket#{{ticket_id}}] {{ticket_subject}}<br><br>Click here to reply:&nbsp; {{link}}</b></p><p>----------------------------------------------</p><p>Here is the reply : <br></p><p> {{reply}}<br></p></div><div><br></div>', '{{subject}}\r\n\r\n{{reply}}\r\n\r\n\r\nClick here to reply:  {{link}}', '{\"ticket_id\":\"Support Ticket ID\", \"ticket_subject\":\"Subject Of Support Ticket\", \"reply\":\"Reply from Staff/Admin\",\"link\":\"Ticket URL For relpy\"}', 1, 1, '2020-06-08 18:00:00', '2020-05-04 02:24:40'),
(8, 'DEPOSIT_COMPLETE', 'Automated Deposit - Successful', 'Deposit Completed Successfully', '<div>Your deposit of <b>{{amount}} {{currency}}</b> is via&nbsp; <b>{{method_name}} </b>has been completed Successfully.<b><br></b></div><div><b><br></b></div><div><b>Details of your Deposit :<br></b></div><div><br></div><div>Amount : {{amount}} {{currency}}</div><div>Charge: <font color=\"#000000\">{{charge}} {{currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}} <br></div><div>Paid via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><font size=\"5\"><b><br></b></font></div><div><font size=\"5\">Your current Balance is <b>{{post_balance}} {{currency}}</b></font></div><div><br></div><div><br><br><br></div>', '{{amount}} {{currrency}} Deposit successfully by {{gateway_name}}', '{\"method_name\": \"Deposit Method Name\",\"method_currency\": \"Deposit Method Currency\",\"method_amount\": \"Deposit Method Amount After Conversion\",\"amount\": \"Request Amount By user\",\"charge\": \"Gateway Charge\",\"currency\": \"Site Currency\",\"rate\": \"Conversion Rate\",\"trx\": \"Transaction Number\",\"post_balance\": \"Users Balance After this operation\"}', 1, 1, '2020-06-24 18:00:00', '2020-07-07 06:39:22'),
(9, 'DEPOSIT_REQUEST', 'Manual Deposit - User Requested', 'Deposit Request Submitted Successfully', '<div>Your deposit request of <b>{{amount}} {{currency}}</b> is via&nbsp; <b>{{method_name}} </b>submitted successfully<b> .<br></b></div><div><b><br></b></div><div><b>Details of your Deposit :<br></b></div><div><br></div><div>Amount : {{amount}} {{currency}}</div><div>Charge: <font color=\"#FF0000\">{{charge}} {{currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}} <br></div><div>Pay via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div><div><br></div>', '{{amount}} Deposit requested by {{method}}. Charge: {{charge}} . Trx: {{trx}}\r\n', '{\"method_name\": \"Deposit Method Name\",\"method_currency\": \"Deposit Method Currency\",\"method_amount\": \"Deposit Method Amount After Conversion\",\"amount\": \"Request Amount By user\",\"charge\": \"Gateway Charge\",\"currency\": \"Site Currency\",\"rate\": \"Conversion Rate\",\"trx\": \"Transaction Number\"}', 1, 1, '2020-05-31 18:00:00', '2020-06-01 18:00:00'),
(10, 'DEPOSIT_APPROVE', 'Manual Deposit - Admin Approved', 'Your Deposit is Approved', '<div>Your deposit request of <b>{{amount}} {{currency}}</b> is via&nbsp; <b>{{method_name}} </b>is Approved .<b><br></b></div><div><b><br></b></div><div><b>Details of your Deposit :<br></b></div><div><br></div><div>Amount : {{amount}} {{currency}}</div><div>Charge: <font color=\"#FF0000\">{{charge}} {{currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}} <br></div><div>Paid via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><font size=\"5\"><b><br></b></font></div><div><font size=\"5\">Your current Balance is <b>{{post_balance}} {{currency}}</b></font></div><div><br></div><div><br><br></div>', 'Admin Approve Your {{amount}} {{gateway_currency}} payment request by {{gateway_name}} transaction : {{transaction}}', '{\"method_name\": \"Deposit Method Name\",\"method_currency\": \"Deposit Method Currency\",\"method_amount\": \"Deposit Method Amount After Conversion\",\"amount\": \"Request Amount By user\",\"charge\": \"Gateway Charge\",\"currency\": \"Site Currency\",\"rate\": \"Conversion Rate\",\"trx\": \"Transaction Number\",\"post_balance\": \"Users Balance After this operation\"}', 1, 1, '2020-06-16 18:00:00', '2020-06-14 18:00:00'),
(11, 'DEPOSIT_REJECT', 'Manual Deposit - Admin Rejected', 'Your Deposit Request is Rejected', '<div>Your deposit request of <b>{{amount}} {{currency}}</b> is via&nbsp; <b>{{method_name}} has been rejected</b>.<b><br></b></div><br><div>Transaction Number was : {{trx}}</div><div><br></div><div>if you have any query, feel free to contact us.<br></div><br><div><br><br></div>\r\n\r\n\r\n\r\n{{rejection_message}}', 'Admin Rejected Your {{amount}} {{gateway_currency}} payment request by {{gateway_name}}\r\n\r\n{{rejection_message}}', '{\"method_name\": \"Deposit Method Name\",\"method_currency\": \"Deposit Method Currency\",\"method_amount\": \"Deposit Method Amount After Conversion\",\"amount\": \"Request Amount By user\",\"charge\": \"Gateway Charge\",\"currency\": \"Site Currency\",\"rate\": \"Conversion Rate\",\"trx\": \"Transaction Number\",\"rejection_message\": \"Rejection message\"}', 1, 1, '2020-06-09 18:00:00', '2020-06-14 18:00:00'),
(12, 'WITHDRAW_REQUEST', 'Withdraw  - User Requested', 'Withdraw Request Submitted Successfully', '<div>Your withdraw request of <b>{{amount}} {{currency}}</b>&nbsp; via&nbsp; <b>{{method_name}} </b>has been submitted Successfully.<b><br></b></div><div><b><br></b></div><div><b>Details of your withdraw:<br></b></div><div><br></div><div>Amount : {{amount}} {{currency}}</div><div>Charge: <font color=\"#FF0000\">{{charge}} {{currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div><div>You will get: {{method_amount}} {{method_currency}} <br></div><div>Via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><font size=\"4\" color=\"#FF0000\"><b><br></b></font></div><div><font size=\"4\" color=\"#FF0000\"><b>This may take {{delay}} to process the payment.</b></font><br></div><div><font size=\"5\"><b><br></b></font></div><div><font size=\"5\"><b><br></b></font></div><div><font size=\"5\">Your current Balance is <b>{{post_balance}} {{currency}}</b></font></div><div><br></div><div><br><br><br><br></div>', '{{amount}} {{currency}} withdraw requested by {{withdraw_method}}. You will get {{method_amount}} {{method_currency}} in {{duration}}. Trx: {{trx}}', '{\"method_name\": \"Method Name\",\"method_currency\": \"Method Currency\",\"method_amount\": \"Method Amount After Conversion\",\"amount\": \"Request Amount By user\",\"charge\": \"Gateway Charge\",\"currency\": \"Site Currency\",\"rate\": \"Conversion Rate\",\"trx\": \"Transaction Number\",\"post_balance\": \"Users Balance After this operation\"}', 1, 1, '2020-06-07 18:00:00', '2020-06-14 18:00:00'),
(13, 'WITHDRAW_REJECT', 'Withdraw - Admin Rejected', 'Withdraw Request has been Rejected and your money is refunded to your account', '<div>Your withdraw request of <b>{{amount}} {{currency}}</b>&nbsp; via&nbsp; <b>{{method_name}} </b>has been Rejected.<b><br></b></div><div><b><br></b></div><div><b>Details of your withdraw:<br></b></div><div><br></div><div>Amount : {{amount}} {{currency}}</div><div>Charge: <font color=\"#FF0000\">{{charge}} {{currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div><div>You should get: {{method_amount}} {{method_currency}} <br></div><div>Via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div><div><br></div><div>----</div><div><font size=\"3\"><br></font></div><div><font size=\"3\"> {{amount}} {{currency}} has been <b>refunded </b>to your account and your current Balance is <b>{{post_balance}}</b><b> {{currency}}</b></font></div><div><br></div><div>-----</div><div><br></div><div><font size=\"4\">Details of Rejection :</font></div><div><font size=\"4\"><b>{{admin_details}}</b></font></div><div><br></div><div><br><br><br><br><br><br></div>', 'Admin Rejected Your {{amount}} {{currency}} withdraw request. Your Main Balance {{main_balance}}  {{method}} , Transaction {{transaction}}', '{\"method_name\": \"Method Name\",\"method_currency\": \"Method Currency\",\"method_amount\": \"Method Amount After Conversion\",\"amount\": \"Request Amount By user\",\"charge\": \"Gateway Charge\",\"currency\": \"Site Currency\",\"rate\": \"Conversion Rate\",\"trx\": \"Transaction Number\",\"post_balance\": \"Users Balance After this operation\",\"admin_details\": \"Details Provided By Admin\"}', 1, 1, '2020-06-09 18:00:00', '2020-06-14 18:00:00'),
(14, 'WITHDRAW_APPROVE', 'Withdraw - Admin  Approved', 'Withdraw Request has been Processed and your money is sent', '<div>Your withdraw request of <b>{{amount}} {{currency}}</b>&nbsp; via&nbsp; <b>{{method_name}} </b>has been Processed Successfully.<b><br></b></div><div><b><br></b></div><div><b>Details of your withdraw:<br></b></div><div><br></div><div>Amount : {{amount}} {{currency}}</div><div>Charge: <font color=\"#FF0000\">{{charge}} {{currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div><div>You will get: {{method_amount}} {{method_currency}} <br></div><div>Via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div><div>-----</div><div><br></div><div><font size=\"4\">Details of Processed Payment :</font></div><div><font size=\"4\"><b>{{admin_details}}</b></font></div><div><br></div><div><br><br><br><br><br></div>', 'Admin Approve Your {{amount}} {{currency}} withdraw request by {{method}}. Transaction {{transaction}}', '{\"method_name\": \"Method Name\",\"method_currency\": \"Method Currency\",\"method_amount\": \"Method Amount After Conversion\",\"amount\": \"Request Amount By user\",\"charge\": \"Gateway Charge\",\"currency\": \"Site Currency\",\"rate\": \"Conversion Rate\",\"trx\": \"Transaction Number\",\"admin_details\": \"Details Provided By Admin\"}', 1, 1, '2020-06-10 18:00:00', '2020-06-06 18:00:00'),
(15, 'BAL_ADD', 'Balance Add by Admin', 'Your Account has been Credited', '<div>{{amount}} {{currency}} has been added to your account .</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div>Your Current Balance is : <font size=\"3\"><b>{{post_balance}}&nbsp; {{currency}}</b></font>', '{{amount}} {{currency}} credited in your account. Your Current Balance {{remaining_balance}} {{currency}} . Transaction: #{{trx}}', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By Admin\",\"currency\":\"Site Currency\", \"post_balance\":\"Users Balance After this operation\"}', 1, 1, '2019-09-14 19:14:22', '2019-11-10 09:07:12'),
(16, 'BAL_SUB', 'Balance Subtracted by Admin', 'Your Account has been Debited', '<div>{{amount}} {{currency}} has been subtracted from your account .</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div>Your Current Balance is : <font size=\"3\"><b>{{post_balance}}&nbsp; {{currency}}</b></font>', '{{amount}} {{currency}} debited from your account. Your Current Balance {{remaining_balance}} {{currency}} . Transaction: #{{trx}}', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By Admin\",\"currency\":\"Site Currency\", \"post_balance\":\"Users Balance After this operation\"}', 1, 1, '2019-09-14 19:14:22', '2019-11-10 09:07:12'),
(17, 'INVESTMENT_PURCHASE', 'Investment Plan Purchase', 'Investment Plan Purchase', 'Congratulation, Successfully Invest complete. You invest  {{amount}} {{currency}}  And you will get {{interest_amount}} {{currency}} interest.', 'Congratulation, Successfully Invest complete. You invest  {{amount}} {{currency}}  And you will get {{interest_amount}} {{currency}} interest.', '{\"amount\":\"amount\",\"interest_amount\":\"interest amount\",\"trx\":\"transaction\",\"currency\":\"currency\"}', 1, 1, '2019-09-14 19:14:22', '2019-11-10 09:07:12'),
(18, 'REFERRAL_COMMISSION', 'REFERRAL COMMISSION', 'REFERRAL COMMISSION', 'Congratulation, You you  {{amount}} {{currency}} interest And your main balance {{main_balance}} {{currency}} . {{level}} . Transaction {{trx}}', 'Congratulation, You you  {{amount}} {{currency}} interest And your main balance {{main_balance}} {{currency}} . {{level}} . Transaction {{trx}}', '{\"amount\":\"amount\",\"main_balance\":\"main balance\",\"trx\":\"transaction\",\"level\":\"level\",\"currency\":\"currency\"}', 1, 1, '2019-09-14 19:14:22', '2019-11-10 09:07:12'),
(19, 'BALANCE_TRANSFER', 'Balance Transfer', 'Balance Transfer', NULL, NULL, '{\"wallet_type\":\"Wallet Type\",\"amount\":\"Amount\",\"charge\":\"Charge\",\"afterCharge\":\"After Charge\",\"post_balance\":\"Post Balance\",\"currency\":\"Currency Text\",\"receiver\":\"Receiver\"}', 1, 1, NULL, NULL),
(20, 'BALANCE_RECEIVE', 'Balance Receive', 'Balance Receive', NULL, NULL, '{\"wallet_type\":\"Wallet Type\",\"amount\":\"Amount\",\"post_balance\":\"Post Balance\",\"currency\":\"Currency Text\",\"sender\":\"Sender\"}', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` int(10) UNSIGNED NOT NULL,
  `data_keys` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_values` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `created_at`, `updated_at`) VALUES
(1, 'seo.data', '{\"seo_image\":\"1\",\"keywords\":[\"hyip\",\"bitcoin\",\"investment\",\"hyip business\",\"hyip script\",\"best hyip\",\"buy hyip script\",\"advanced hyip script\",\"hyip software\",\"high yield investment program\",\"hyip manager\",\"hyip manager script\",\"cheap hyip script\",\"reliable hyip\",\"secure hyip script\",\"php hyip script\",\"new hyip script\",\"hyip program\"],\"description\":\"HYIP Lab - Complete HYIP Investment System . Most Advanced HYIP Investment System Script in codecanyon.\\r\\n\\r\\nhyip, bitcoin, investment,  hyip business, hyip script, best hyip, buy hyip script, advanced hyip script, hyip software, high yield investment program, hyip manager, hyip manager script, cheap hyip script, reliable hyip, secure hyip script, php hyip script, new hyip script, hyip program\",\"social_title\":\"HYIP Lab - Complete HYIP Investment System\",\"social_description\":\"HYIP Lab - Complete HYIP Investment System . Most Advanced HYIP Investment System Script in codecanyon.\",\"image\":\"5fcc92c79ffe31607242439.jpg\"}', '2020-07-04 23:42:52', '2020-12-06 08:13:59'),
(153, 'about.content', '{\"has_image\":\"1\",\"heading_w\":\"About\",\"heading_c\":\"Us\",\"button_name\":\"More Info\",\"button_link\":\"about\",\"content\":\"We are an international financial company engaged in investment activities, which are related to trading on financial markets and cryptocurrency exchanges performed by qualified professional traders.\\r\\n\\r\\nOur goal is to provide our investors with a reliable source of high income, while minimizing any possible risks and offering a high-quality service, allowing us to automate and simplify the relations between the investors and the trustees. We work towards increasing your profit margin by profitable investment. We look forward to you being part of our community.\",\"image\":\"60b60b6574cd91622543205.jpg\"}', '2020-12-07 14:06:54', '2021-06-01 04:26:45'),
(154, 'banner.content', '{\"has_image\":\"1\",\"heading_w\":\"Invest for Future in Stable Platform\",\"heading_c\":\"and Make Fast Money\",\"sub_heading\":\"Invest in an Industry Leader, Professional, and Reliable Company. We provide you with the most necessary features that will make your experience better. Not only we guarantee the fastest and the most exciting returns on your investments, but we also guarantee the security of your investment.\",\"button_name\":\"Sign Up\",\"button_link\":\"register\",\"image\":\"5fce371bad7db1607350043.jpg\"}', '2020-12-07 14:07:23', '2020-12-07 14:07:24'),
(155, 'blog.content', '{\"heading\":\"Our Latest News\",\"sub_heading\":\"you will get each update about our system and the world market in this area. Keep checking our Latest News to be in touch.\"}', '2020-12-07 14:07:46', '2020-12-07 14:07:46'),
(156, 'blog.element', '{\"has_image\":\"1\",\"title\":\"Voluptatum est expedita officia established  fact\",\"description\":\"<span style=\\\"color:rgb(255,255,255);font-family:Exo, sans-serif;background-color:rgb(16,17,19);\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><br \\/>\",\"image\":\"5fce37604096d1607350112.jpg\"}', '2020-12-07 14:08:32', '2020-12-07 14:08:32'),
(157, 'blog.element', '{\"has_image\":\"1\",\"title\":\"amet quisquam ut vitae debitis iste.\",\"description\":\"<span style=\\\"color:rgb(255,255,255);font-family:Exo, sans-serif;background-color:rgb(16,17,19);\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><br \\/>\",\"image\":\"5fce3776cc0b61607350134.jpg\"}', '2020-12-07 14:08:54', '2020-12-07 14:08:55'),
(158, 'blog.element', '{\"has_image\":\"1\",\"title\":\"It is a long established fact that a reade\",\"description\":\"<span style=\\\"color:rgb(255,255,255);font-family:Exo, sans-serif;background-color:rgb(16,17,19);\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><br \\/>\",\"image\":\"5fce378a3206a1607350154.jpg\"}', '2020-12-07 14:09:14', '2020-12-07 14:09:14'),
(159, 'blog.element', '{\"has_image\":\"1\",\"title\":\"Voluptatum est expedita officia, eos\",\"description\":\"<span style=\\\"color:rgb(255,255,255);font-family:Exo, sans-serif;background-color:rgb(16,17,19);\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><br \\/>\",\"image\":\"5fce37cc2b8101607350220.jpg\"}', '2020-12-07 14:10:20', '2020-12-07 14:10:20'),
(160, 'blog.element', '{\"has_image\":\"1\",\"title\":\"amet quisquam ut vitae debitis iste.\",\"description\":\"<span style=\\\"color:rgb(255,255,255);font-family:Exo, sans-serif;background-color:rgb(16,17,19);\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><br \\/>\",\"image\":\"5fce37fae7fdf1607350266.jpg\"}', '2020-12-07 14:11:06', '2020-12-07 14:11:07'),
(161, 'blog.element', '{\"has_image\":\"1\",\"title\":\"voluptates ratione mollitia sequi quia asperiores sint\",\"description\":\"<span style=\\\"color:rgb(255,255,255);font-family:Exo, sans-serif;background-color:rgb(16,17,19);\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><br \\/>\",\"image\":\"5fce380ced66f1607350284.jpg\"}', '2020-12-07 14:11:24', '2020-12-07 14:11:25'),
(162, 'breadcrumb.content', '{\"has_image\":\"1\",\"image\":\"5fce3837032a51607350327.jpg\"}', '2020-12-07 14:12:07', '2020-12-07 14:12:08'),
(163, 'calculation.content', '{\"heading_w\":\"Profit\",\"heading_c\":\"Calculator\",\"sub_heading\":\"You must know the calculation before investing in any plan, so you never make mistakes. Check the calculation and you will get as our calculator says.\"}', '2020-12-07 14:12:30', '2020-12-07 14:12:30'),
(164, 'contact.content', '{\"has_image\":\"1\",\"heading\":\"Contact With Us\",\"sub_heading\":\"If you have any questions or queries that are not answered on our website, please feel free to contact us. We will try to respond to you as soon as possible. Thank you so much.\",\"image\":\"5fce3861b2a1c1607350369.jpg\"}', '2020-12-07 14:12:49', '2020-12-07 14:12:50'),
(165, 'contact.element', '{\"icon\":\"<i class=\\\"las la-phone\\\"><\\/i>\",\"title\":\"Phone Number\",\"content\":\"+01234 5678 9000\"}', '2020-12-07 14:13:09', '2020-12-07 14:13:09'),
(166, 'contact.element', '{\"icon\":\"<i class=\\\"las la-envelope-open\\\"><\\/i>\",\"title\":\"Email Address\",\"content\":\"demo@example.com\"}', '2020-12-07 14:13:28', '2020-12-07 14:13:28'),
(167, 'contact.element', '{\"icon\":\"<i class=\\\"las la-map-marker\\\"><\\/i>\",\"title\":\"Office Address\",\"content\":\"3015 Suit pagla road, Singapore\"}', '2020-12-07 14:13:42', '2020-12-07 14:13:42'),
(168, 'cta.content', '{\"has_image\":\"1\",\"heading\":\"Get Started Today With Us\",\"sub_heading\":\"This is a Revolutionary Money Making Platform! Invest for Future in Stable Platform and Make Fast Money. Not only we guarantee the fastest and the most exciting returns on your investments, but we also guarantee the security of your investment.\",\"button_name\":\"Join Us\",\"button_url\":\"register\",\"image\":\"5fce38bab36371607350458.jpg\"}', '2020-12-07 14:14:18', '2020-12-07 14:14:19'),
(169, 'faq.content', '{\"heading_w\":\"Frequently Asked\",\"heading_c\":\"Questions\",\"sub_heading\":\"We answer some of your Frequently Asked Questions regarding our platform. If you have a query that is not answered here, Please contact us.\"}', '2020-12-07 14:14:44', '2020-12-07 14:14:44'),
(170, 'faq.element', '{\"question\":\"When can I deposit\\/withdraw from my Investment account?\",\"answer\":\"Deposit and withdrawal are available for at any time. Be sure, that your funds are not used in any ongoing trade before the withdrawal. The available amount is shown in your dashboard on the main page of Investing platform.\\r\\n\\r\\nDeposit and withdrawal are available for at any time. Be sure, that your funds are not used in any ongoing trade before the withdrawal. The available amount is shown in your dashboard on the main page of Investing platform.\"}', '2020-12-07 14:15:11', '2020-12-07 14:15:11'),
(171, 'faq.element', '{\"question\":\"How do I check my account balance?\",\"answer\":\"You can see this anytime on your accounts dashboard.  You can see this anytime on your accounts dashboard.\"}', '2020-12-07 14:15:34', '2020-12-07 14:15:34'),
(172, 'faq.element', '{\"question\":\"I forgot my password, what should I do?\",\"answer\":\"Visit the password reset page, type in your email address and click the `Reset` button.\\r\\n\\r\\nVisit the password reset page, type in your email address and click the `Reset` button.\"}', '2020-12-07 14:16:10', '2020-12-07 14:16:10'),
(173, 'faq.element', '{\"question\":\"How will I know that the withdrawal has been successful?\",\"answer\":\"You will get an automatic notification once we send the funds and you can always check your transactions or account balance. Your chosen payment system dictates how long it will take for the funds to reach you.\\r\\n\\r\\n You will get an automatic notification once we send the funds and you can always check your transactions or account balance. Your chosen payment system dictates how long it will take for the funds to reach you.\"}', '2020-12-07 14:16:32', '2020-12-07 14:16:32'),
(174, 'faq.element', '{\"question\":\"How much can I withdraw?\",\"answer\":\"You can withdraw the full amount of your account balance minus the funds that are used currently for supporting opened positions.\\r\\n\\r\\n                                You can withdraw the full amount of your account balance minus the funds that are used currently for supporting opened positions.\"}', '2020-12-07 14:16:53', '2020-12-07 14:16:53'),
(175, 'footer.content', '{\"has_image\":\"1\",\"image\":\"5fce39681ce6b1607350632.jpg\"}', '2020-12-07 14:17:12', '2020-12-07 14:17:12'),
(176, 'how_work.content', '{\"has_image\":\"1\",\"heading_w_1\":\"How\",\"heading_c\":\"Hyiplab\",\"heading_w_2\":\"Works\",\"sub_heading\":\"Get involved in our tremendous platform and Invest. We will utilize your money and give you profit in your wallet automatically.\",\"image\":\"5fce39883b22c1607350664.jpg\"}', '2020-12-07 14:17:44', '2020-12-07 14:17:44'),
(177, 'how_work.element', '{\"title\":\"Crea\",\"icon\":\"<i class=\\\"las la-user\\\"><\\/i>\"}', '2020-12-07 14:17:57', '2020-12-07 14:17:57'),
(178, 'how_work.element', '{\"id\":\"178\",\"title\":\"Invest To Plan\",\"icon\":\"<i class=\\\"las la-cubes\\\"><\\/i>\"}', '2020-12-07 14:18:11', '2020-12-07 14:18:31'),
(179, 'how_work.element', '{\"title\":\"Get Profit\",\"icon\":\"<i class=\\\"las la-wallet\\\"><\\/i>\"}', '2020-12-07 14:18:21', '2020-12-07 14:18:21'),
(180, 'links.element', '{\"title\":\"Privacy &amp; Policy\",\"content\":\"<h2 style=\\\"margin-bottom:10px;font-weight:600;line-height:24px;font-size:24px;font-family:DauphinPlain;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;\\\"><font color=\\\"#ffffff\\\">What is Lorem Ipsum?<\\/font><\\/h2><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;\\\"><font color=\\\"#ffffff\\\"><span style=\\\"font-weight:bolder;margin-top:0px;margin-right:0px;margin-left:0px;padding:0px;\\\">Lorem Ipsum<\\/span>\\u00a0is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/font><\\/p><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;\\\"><font color=\\\"#ffffff\\\"><br \\/><\\/font><\\/p><h2 style=\\\"margin-bottom:10px;font-weight:600;line-height:24px;font-size:24px;font-family:DauphinPlain;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;\\\"><font color=\\\"#ffffff\\\">What is Lorem Ipsum?<\\/font><\\/h2><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;\\\"><font color=\\\"#ffffff\\\"><span style=\\\"font-weight:bolder;margin-top:0px;margin-right:0px;margin-left:0px;padding:0px;\\\">Lorem Ipsum<\\/span>\\u00a0is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/font><\\/p><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;\\\"><font color=\\\"#ffffff\\\"><br \\/><\\/font><\\/p><h2 style=\\\"margin-bottom:10px;font-weight:600;line-height:24px;font-size:24px;font-family:DauphinPlain;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;\\\"><font color=\\\"#ffffff\\\">What is Lorem Ipsum?<\\/font><\\/h2><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;\\\"><font color=\\\"#ffffff\\\"><span style=\\\"font-weight:bolder;margin-top:0px;margin-right:0px;margin-left:0px;padding:0px;\\\">Lorem Ipsum<\\/span>\\u00a0is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/font><\\/p><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;\\\"><font color=\\\"#ffffff\\\"><br \\/><\\/font><\\/p><h2 style=\\\"margin-bottom:10px;font-weight:600;line-height:24px;font-size:24px;font-family:DauphinPlain;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;\\\"><font color=\\\"#ffffff\\\">What is Lorem Ipsum?<\\/font><\\/h2><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;\\\"><font color=\\\"#ffffff\\\"><span style=\\\"font-weight:bolder;margin-top:0px;margin-right:0px;margin-left:0px;padding:0px;\\\">Lorem Ipsum<\\/span>\\u00a0is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/font><\\/p><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;\\\"><font color=\\\"#ffffff\\\"><br \\/><\\/font><\\/p><h2 style=\\\"margin-bottom:10px;font-weight:600;line-height:24px;font-size:24px;font-family:DauphinPlain;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;\\\"><font color=\\\"#ffffff\\\">What is Lorem Ipsum?<\\/font><\\/h2><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;\\\"><font color=\\\"#ffffff\\\"><span style=\\\"font-weight:bolder;margin-top:0px;margin-right:0px;margin-left:0px;padding:0px;\\\">Lorem Ipsum<\\/span>\\u00a0is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/font><\\/p><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;\\\"><font color=\\\"#ffffff\\\"><br \\/><\\/font><\\/p><h2 style=\\\"margin-bottom:10px;font-weight:600;line-height:24px;font-size:24px;font-family:DauphinPlain;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;\\\"><font color=\\\"#ffffff\\\">What is Lorem Ipsum?<\\/font><\\/h2><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;\\\"><font color=\\\"#ffffff\\\"><span style=\\\"font-weight:bolder;margin-top:0px;margin-right:0px;margin-left:0px;padding:0px;\\\">Lorem Ipsum<\\/span>\\u00a0is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/font><\\/p><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;\\\"><font color=\\\"#ffffff\\\"><br \\/><\\/font><\\/p><h2 style=\\\"margin-bottom:10px;font-weight:600;line-height:24px;font-size:24px;font-family:DauphinPlain;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;\\\"><font color=\\\"#ffffff\\\">What is Lorem Ipsum?<\\/font><\\/h2><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;\\\"><font color=\\\"#ffffff\\\"><span style=\\\"font-weight:bolder;margin-top:0px;margin-right:0px;margin-left:0px;padding:0px;\\\">Lorem Ipsum<\\/span>\\u00a0is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/font><\\/p><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;\\\"><font color=\\\"#ffffff\\\"><br \\/><\\/font><\\/p><h2 style=\\\"margin-bottom:10px;font-weight:600;line-height:24px;font-size:24px;font-family:DauphinPlain;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;\\\"><font color=\\\"#ffffff\\\">What is Lorem Ipsum?<\\/font><\\/h2><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;\\\"><font color=\\\"#ffffff\\\"><span style=\\\"font-weight:bolder;margin-top:0px;margin-right:0px;margin-left:0px;padding:0px;\\\">Lorem Ipsum<\\/span>\\u00a0is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/font><\\/p>\"}', '2020-12-07 14:19:02', '2020-12-07 14:19:02'),
(181, 'links.element', '{\"title\":\"Terms &amp; Condition\",\"content\":\"<h2 style=\\\"margin-bottom:10px;font-weight:600;line-height:24px;font-size:24px;font-family:DauphinPlain;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;\\\"><font color=\\\"#ffffff\\\">What is Lorem Ipsum?<\\/font><\\/h2><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);font-size:14px;padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;\\\"><font color=\\\"#ffffff\\\"><span style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;font-weight:bolder;padding:0px;\\\">Lorem Ipsum<\\/span>\\u00a0is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/font><\\/p><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);font-size:14px;padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;\\\"><font color=\\\"#ffffff\\\"><br \\/><\\/font><\\/p><h2 style=\\\"margin-bottom:10px;font-weight:600;line-height:24px;font-size:24px;font-family:DauphinPlain;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;\\\"><font color=\\\"#ffffff\\\">What is Lorem Ipsum?<\\/font><\\/h2><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);font-size:14px;padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;\\\"><font color=\\\"#ffffff\\\"><span style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;font-weight:bolder;padding:0px;\\\">Lorem Ipsum<\\/span>\\u00a0is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/font><\\/p><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);font-size:14px;padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;\\\"><font color=\\\"#ffffff\\\"><br \\/><\\/font><\\/p><h2 style=\\\"margin-bottom:10px;font-weight:600;line-height:24px;font-size:24px;font-family:DauphinPlain;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;\\\"><font color=\\\"#ffffff\\\">What is Lorem Ipsum?<\\/font><\\/h2><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);font-size:14px;padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;\\\"><font color=\\\"#ffffff\\\"><span style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;font-weight:bolder;padding:0px;\\\">Lorem Ipsum<\\/span>\\u00a0is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/font><\\/p><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);font-size:14px;padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;\\\"><font color=\\\"#ffffff\\\"><br \\/><\\/font><\\/p><h2 style=\\\"margin-bottom:10px;font-weight:600;line-height:24px;font-size:24px;font-family:DauphinPlain;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;\\\"><font color=\\\"#ffffff\\\">What is Lorem Ipsum?<\\/font><\\/h2><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);font-size:14px;padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;\\\"><font color=\\\"#ffffff\\\"><span style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;font-weight:bolder;padding:0px;\\\">Lorem Ipsum<\\/span>\\u00a0is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/font><\\/p><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);font-size:14px;padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;\\\"><font color=\\\"#ffffff\\\"><br \\/><\\/font><\\/p><h2 style=\\\"margin-bottom:10px;font-weight:600;line-height:24px;font-size:24px;font-family:DauphinPlain;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;\\\"><font color=\\\"#ffffff\\\">What is Lorem Ipsum?<\\/font><\\/h2><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);font-size:14px;padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;\\\"><font color=\\\"#ffffff\\\"><span style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;font-weight:bolder;padding:0px;\\\">Lorem Ipsum<\\/span>\\u00a0is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/font><\\/p><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);font-size:14px;padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;\\\"><font color=\\\"#ffffff\\\"><br \\/><\\/font><\\/p><h2 style=\\\"margin-bottom:10px;font-weight:600;line-height:24px;font-size:24px;font-family:DauphinPlain;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;\\\"><font color=\\\"#ffffff\\\">What is Lorem Ipsum?<\\/font><\\/h2><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);font-size:14px;padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;\\\"><font color=\\\"#ffffff\\\"><span style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;font-weight:bolder;padding:0px;\\\">Lorem Ipsum<\\/span>\\u00a0is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/font><\\/p><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);font-size:14px;padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;\\\"><font color=\\\"#ffffff\\\"><br \\/><\\/font><\\/p><h2 style=\\\"margin-bottom:10px;font-weight:600;line-height:24px;font-size:24px;font-family:DauphinPlain;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;\\\"><font color=\\\"#ffffff\\\">What is Lorem Ipsum?<\\/font><\\/h2><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);font-size:14px;padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;\\\"><font color=\\\"#ffffff\\\"><span style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;font-weight:bolder;padding:0px;\\\">Lorem Ipsum<\\/span>\\u00a0is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/font><\\/p><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);font-size:14px;padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;\\\"><font color=\\\"#ffffff\\\"><br \\/><\\/font><\\/p><h2 style=\\\"margin-bottom:10px;font-weight:600;line-height:24px;font-size:24px;font-family:DauphinPlain;color:rgb(255,255,255);background-color:rgb(16,17,19);padding:0px;\\\"><font color=\\\"#ffffff\\\">What is Lorem Ipsum?<\\/font><\\/h2><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;color:rgb(255,255,255);background-color:rgb(16,17,19);font-size:14px;padding:0px;text-align:justify;font-family:\'Open Sans\', Arial, sans-serif;\\\"><font color=\\\"#ffffff\\\"><span style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;font-weight:bolder;padding:0px;\\\">Lorem Ipsum<\\/span>\\u00a0is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/font><\\/p>\"}', '2020-12-07 14:19:18', '2020-12-07 14:19:18'),
(182, 'login.content', '{\"has_image\":\"1\",\"heading_w\":\"Welcome To\",\"heading_c\":\"Hyiplab\",\"sub_heading\":\"Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus distinctio deserunt impedit similique debitis voluptatum enim.\",\"section_bg\":\"5fce3a113b6d91607350801.jpg\",\"card_bg\":\"5fce3a1188a861607350801.jpg\"}', '2020-12-07 14:20:01', '2020-12-07 14:20:01'),
(183, 'plan.content', '{\"heading_w\":\"Investment\",\"heading_c\":\"Plans\",\"sub_heading\":\"To make a solid investment, you have to know where you are investing. Find a plan which is best for you.\"}', '2020-12-07 14:20:34', '2020-12-07 14:20:34'),
(184, 'register.content', '{\"has_image\":\"1\",\"heading_w\":\"Welcome To\",\"heading_c\":\"Hyiplab\",\"sub_heading\":\"Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus distinctio deserunt impedit similique debitis voluptatum enim.\",\"section_bg\":\"5fce3a4f0b6131607350863.jpg\",\"card_bg\":\"5fce3a4f5d06e1607350863.jpg\"}', '2020-12-07 14:21:02', '2020-12-07 14:21:03'),
(185, 'social_icon.element', '{\"id\":\"185\",\"icon\":\"<i class=\\\"lab la-facebook-f\\\"><\\/i>\",\"url\":\"https:\\/\\/facebook.com\"}', '2020-12-07 14:21:25', '2020-12-07 14:22:41'),
(186, 'social_icon.element', '{\"id\":\"186\",\"icon\":\"<i class=\\\"lab la-twitter\\\"><\\/i>\",\"url\":\"https:\\/\\/www.twitter.com\\/\"}', '2020-12-07 14:22:19', '2020-12-07 14:22:51'),
(187, 'social_icon.element', '{\"icon\":\"<i class=\\\"lab la-pinterest-p\\\"><\\/i>\",\"url\":\"https:\\/\\/www.pinterest.com\\/\"}', '2020-12-07 14:23:12', '2020-12-07 14:23:12'),
(188, 'social_icon.element', '{\"icon\":\"<i class=\\\"lab la-linkedin-in\\\"><\\/i>\",\"url\":\"https:\\/\\/www.linkedin.com\\/\"}', '2020-12-07 14:23:27', '2020-12-07 14:23:27'),
(189, 'subscribe.content', '{\"has_image\":\"1\",\"heading\":\"Subscribe Our Newsletter\",\"image\":\"5fce3af5a116f1607351029.jpg\"}', '2020-12-07 14:23:49', '2020-12-07 14:23:49'),
(190, 'team.content', '{\"has_image\":\"1\",\"heading_w\":\"Our Expert\",\"heading_c\":\"Team Members\",\"sub_heading\":\"We have a great team including developers, designers, and Traders. The Team always working hard to give you the maximum profit.\",\"image\":\"5fce3b119747a1607351057.jpg\"}', '2020-12-07 14:24:17', '2020-12-07 14:24:18'),
(191, 'team.element', '{\"has_image\":\"1\",\"name\":\"Alex J.\",\"designation\":\"CEO\",\"image\":\"5fce3b26d2c1c1607351078.jpg\"}', '2020-12-07 14:24:38', '2020-12-07 14:24:38'),
(192, 'team.element', '{\"has_image\":\"1\",\"name\":\"Danial K.\",\"designation\":\"CTO\",\"image\":\"5fce3b35de92d1607351093.jpg\"}', '2020-12-07 14:24:53', '2020-12-07 14:24:53'),
(193, 'team.element', '{\"has_image\":\"1\",\"name\":\"Lew Son\",\"designation\":\"Marketing Head\",\"image\":\"5fce3b441d86e1607351108.jpg\"}', '2020-12-07 14:25:08', '2020-12-07 14:25:08'),
(194, 'team.element', '{\"has_image\":\"1\",\"name\":\"Tend z Joe\",\"designation\":\"Designer\",\"image\":\"5fce3b5057e001607351120.jpg\"}', '2020-12-07 14:25:20', '2020-12-07 14:25:20'),
(195, 'team.element', '{\"has_image\":\"1\",\"name\":\"Sam Joe\",\"designation\":\"Developer\",\"image\":\"5fce3b5f679ad1607351135.jpg\"}', '2020-12-07 14:25:35', '2020-12-07 14:25:35'),
(196, 'team.element', '{\"has_image\":\"1\",\"name\":\"Alex Joe\",\"designation\":\"UX Expert\",\"image\":\"5fce3b6d71cdc1607351149.jpg\"}', '2020-12-07 14:25:49', '2020-12-07 14:25:49'),
(197, 'team.element', '{\"has_image\":\"1\",\"name\":\"Juna Sun\",\"designation\":\"SEO Expert\",\"image\":\"5fce3b7c48fb41607351164.jpg\"}', '2020-12-07 14:26:04', '2020-12-07 14:26:04'),
(198, 'team.element', '{\"has_image\":\"1\",\"name\":\"Profed Laun\",\"designation\":\"Manager\",\"image\":\"5fce3b8839ba81607351176.jpg\"}', '2020-12-07 14:26:16', '2020-12-07 14:26:16'),
(199, 'testimonial.content', '{\"has_image\":\"1\",\"heading_w\":\"What Users Say\",\"heading_c\":\"About Us\",\"sub_heading\":\"We are doing really good at this market and here are the words we loved to get from a few of our users.\",\"image\":\"5fce3baa1513c1607351210.jpg\"}', '2020-12-07 14:26:50', '2020-12-07 14:26:50'),
(200, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Monalisa Thakur\",\"designation\":\"User From India\",\"qoute\":\"I have invested with this platform and gotten my money in my account. This is legit and safe. Great doing business with them.\",\"image\":\"5fce3c57867c71607351383.jpg\"}', '2020-12-07 14:29:43', '2020-12-07 14:29:43'),
(201, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Sundax Ezma\",\"designation\":\"User From USA\",\"qoute\":\"Legit....and legit. Although the payment was processed manually, I have received my first payment within a very short time., I think nice for invest at this site.\",\"image\":\"5fce3c75041ad1607351413.jpg\"}', '2020-12-07 14:30:13', '2020-12-07 14:30:13'),
(202, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Donald I.\",\"designation\":\"User From Nigeria\",\"qoute\":\"I have invested with this platform and gotten my money in my account. This is legit and safe. Great doing business with them.\",\"image\":\"5fce3c918a04b1607351441.jpg\"}', '2020-12-07 14:30:41', '2020-12-07 14:30:41'),
(203, 'top_investor.content', '{\"heading_w\":\"Our Top\",\"heading_c\":\"Investors\",\"sub_heading\":\"Here are the investor leaders who have made the maximum investment with our system.\"}', '2020-12-07 14:30:59', '2020-12-07 14:30:59'),
(204, 'transaction.content', '{\"heading\":\"Latest News\",\"sub_heading\":\"Here is the log of the most recent transactions including withdraw and deposit made by our users.\"}', '2020-12-07 14:31:14', '2021-05-26 22:20:21'),
(205, 'we_accept.content', '{\"heading_w\":\"Payment We\",\"heading_c\":\"Accept\",\"sub_heading\":\"We accept all major cryptocurrencies and fiat payment methods to make your investment process easier with our platform.\"}', '2020-12-07 14:31:30', '2020-12-07 14:31:30'),
(206, 'why_choose.content', '{\"has_image\":\"1\",\"heading_w\":\"Why Choose\",\"heading_c\":\"Hyiplab\",\"sub_heading\":\"Our goal is to provide our investors with a reliable source of high income, while minimizing any possible risks and offering a high-quality service.\",\"image\":\"5fce3cf364ca21607351539.jpg\"}', '2020-12-07 14:32:19', '2020-12-07 14:32:19'),
(207, 'why_choose.element', '{\"title\":\"Legal Company\",\"icon\":\"<i class=\\\"las la-copy\\\"><\\/i>\",\"content\":\"Our company conducts absolutely legal activities in the legal field. We are certified to operate investment business, we are legal and safe.\"}', '2020-12-07 14:32:33', '2020-12-07 14:32:33'),
(208, 'why_choose.element', '{\"title\":\"High reliability\",\"icon\":\"<i class=\\\"las la-lock\\\"><\\/i>\",\"content\":\"We are trusted by a huge number of people. We are working hard constantly to improve the level of our security system and minimize possible risks.\"}', '2020-12-07 14:32:47', '2020-12-07 14:32:47'),
(209, 'why_choose.element', '{\"title\":\"Anonymity\",\"icon\":\"<i class=\\\"las la-user-lock\\\"><\\/i>\",\"content\":\"Anonymity and using cryptocurrency as a payment instrument. In the era of electronic money \\u2013 this is one of the most convenient ways of cooperation.\"}', '2020-12-07 14:33:02', '2020-12-07 14:33:02'),
(210, 'why_choose.element', '{\"title\":\"Quick Withdrawal\",\"icon\":\"<i class=\\\"las la-shipping-fast\\\"><\\/i>\",\"content\":\"Our all retreats are treated spontaneously once requested. There are high maximum limits. The minimum withdrawal amount is only $10 .\"}', '2020-12-07 14:33:29', '2020-12-07 14:33:29'),
(211, 'why_choose.element', '{\"title\":\"Referral Program\",\"icon\":\"<i class=\\\"las la-users\\\"><\\/i>\",\"content\":\"We are offering a certain level of referral income through our referral program. you can increase your income by simply refer a few people.\"}', '2020-12-07 14:33:43', '2020-12-07 14:33:43'),
(212, 'why_choose.element', '{\"title\":\"24\\/7 Support\",\"icon\":\"<i class=\\\"las la-headset\\\"><\\/i>\",\"content\":\"We provide 24\\/7 customer support through e-mail and telegram. Our support representatives are periodically available to elucidate any difficulty.\"}', '2020-12-07 14:33:58', '2020-12-07 14:33:58'),
(213, 'why_choose.element', '{\"title\":\"Dedicated Server\",\"icon\":\"<i class=\\\"las la-server\\\"><\\/i>\",\"content\":\"We are using a dedicated server for the website which allows us exclusive use of the resources of the entire server.\"}', '2020-12-07 14:34:13', '2020-12-07 14:34:13'),
(214, 'why_choose.element', '{\"title\":\"SSL Secured\",\"icon\":\"<i class=\\\"lab la-expeditedssl\\\"><\\/i>\",\"content\":\"Comodo Essential-SSL Security encryption confirms that the presented content is genuine and legitimate.\"}', '2020-12-07 14:34:45', '2020-12-07 14:34:45');
INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `created_at`, `updated_at`) VALUES
(215, 'why_choose.element', '{\"title\":\"DDOS Protection\",\"icon\":\"<i class=\\\"las la-shield-alt\\\"><\\/i>\",\"content\":\"We are using one of the most experienced, professional, and trusted DDoS Protection and mitigation provider.\"}', '2020-12-07 14:35:19', '2020-12-07 14:35:19'),
(216, 'cookie.data', '{\"link\":\"#\",\"description\":\"<span style=\\\"color: rgb(255, 255, 255); font-family: Exo, sans-serif; font-size: 18px; background-color: rgb(0, 0, 0);\\\">We may use cookies or any other tracking technologies when you visit our website, including any other media form, mobile website, or mobile application related or connected to help customize the Site and improve your experience.<\\/span><br>\",\"status\":1}', '2020-07-04 23:42:52', '2021-06-01 10:09:12');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` int(11) DEFAULT NULL,
  `alias` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NULL',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `parameters` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supported_currencies` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crypto` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: fiat currency, 1: crypto currency',
  `extra` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `input_form` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `code`, `alias`, `image`, `name`, `status`, `parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `input_form`, `created_at`, `updated_at`) VALUES
(1, 101, 'paypal', '5f6f1bd8678601601117144.jpg', 'Paypal', 1, '{\"paypal_email\":{\"title\":\"PayPal Email\",\"global\":true,\"value\":\"paypal@user.com\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:45:44'),
(2, 102, 'perfect_money', '5f6f1d2a742211601117482.jpg', 'Perfect Money', 1, '{\"passphrase\":{\"title\":\"ALTERNATE PASSPHRASE\",\"global\":true,\"value\":\"6451561651551\"},\"wallet_id\":{\"title\":\"PM Wallet\",\"global\":false,\"value\":\"\"}}', '{\"USD\":\"$\",\"EUR\":\"\\u20ac\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:51:22'),
(3, 103, 'stripe', '5f6f1d4bc69e71601117515.jpg', 'Stripe Hosted', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51HuxFUHyGzEKoTKAfIosswAQduMOGU4q4elcNr8OE6LoBZcp2MHKalOW835wjRiF6fxVTc7RmBgatKfAt1Qq0heb00rUaCOd2T\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51HuxFUHyGzEKoTKAueAuF9BrMDA5boMcpJLLt0vu4q3QdPX5isaGudKNe6OyVjZP1UugpYd6JA7i7TczRWsbutaP004YmBiSp5\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-12-05 09:49:00'),
(4, 104, 'skrill', '5f6f1d41257181601117505.jpg', 'Skrill', 1, '{\"pay_to_email\":{\"title\":\"Skrill Email\",\"global\":true,\"value\":\"merchant@skrill.com\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"---\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"MAD\":\"MAD\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"SAR\":\"SAR\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TND\":\"TND\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\",\"COP\":\"COP\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-10-22 03:35:41'),
(5, 105, 'paytm', '5f6f1d1d3ec731601117469.jpg', 'PayTM', 1, '{\"MID\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"DIY12386817555501617\"},\"merchant_key\":{\"title\":\"Merchant Key\",\"global\":true,\"value\":\"bKMfNxPPf_QdZppa\"},\"WEBSITE\":{\"title\":\"Paytm Website\",\"global\":true,\"value\":\"DIYtestingweb\"},\"INDUSTRY_TYPE_ID\":{\"title\":\"Industry Type\",\"global\":true,\"value\":\"Retail\"},\"CHANNEL_ID\":{\"title\":\"CHANNEL ID\",\"global\":true,\"value\":\"WEB\"},\"transaction_url\":{\"title\":\"Transaction URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/oltp-web\\/processTransaction\"},\"transaction_status_url\":{\"title\":\"Transaction STATUS URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/paytmchecksum\\/paytmCallback.jsp\"}}', '{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:51:09'),
(6, 106, 'payeer', '5f6f1bc61518b1601117126.jpg', 'Payeer', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"866989763\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"7575\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}', 0, '{\"status\":{\"title\": \"Status URL\",\"value\":\"ipn.payeer\"}}', NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:45:26'),
(7, 107, 'paystack', '5f7096563dfb71601214038.jpg', 'PayStack', 1, '{\"public_key\":{\"title\":\"Public key\",\"global\":true,\"value\":\"pk_test_3c9c87f51b13c15d99eb367ca6ebc52cc9eb1f33\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"sk_test_2a3f97a146ab5694801f993b60fcb81cd7254f12\"}}', '{\"USD\":\"USD\",\"NGN\":\"NGN\"}', 0, '{\"callback\":{\"title\": \"Callback URL\",\"value\":\"ipn.paystack\"},\"webhook\":{\"title\": \"Webhook URL\",\"value\":\"ipn.paystack\"}}\r\n', NULL, NULL, '2019-09-14 13:14:22', '2020-09-27 07:40:38'),
(8, 108, 'voguepay', '5f6f1d5951a111601117529.jpg', 'VoguePay', 1, '{\"merchant_id\":{\"title\":\"MERCHANT ID\",\"global\":true,\"value\":\"demo\"}}', '{\"USD\":\"USD\",\"GBP\":\"GBP\",\"EUR\":\"EUR\",\"GHS\":\"GHS\",\"NGN\":\"NGN\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:52:09'),
(9, 109, 'flutterwave', '5f6f1b9e4bb961601117086.jpg', 'Flutterwave', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"demo_publisher_ke\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"demo_secret_key\"},\"encryption_key\":{\"title\":\"Encryption Key\",\"global\":true,\"value\":\"demo_encryption_key\"}}', '{\"KES\":\"KES\",\"GHS\":\"GHS\",\"NGN\":\"NGN\",\"USD\":\"USD\",\"GBP\":\"GBP\",\"EUR\":\"EUR\",\"UGX\":\"UGX\",\"TZS\":\"TZS\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-12-06 14:48:34'),
(10, 110, 'razorpay', '5f6f1d3672dd61601117494.jpg', 'RazorPay', 1, '{\"key_id\":{\"title\":\"Key Id\",\"global\":true,\"value\":\"rzp_test_kiOtejPbRZU90E\"},\"key_secret\":{\"title\":\"Key Secret \",\"global\":true,\"value\":\"osRDebzEqbsE1kbyQJ4y0re7\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:51:34'),
(11, 111, 'stripe_js', '5f7096a31ed9a1601214115.jpg', 'Stripe Storefront', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51HuxFUHyGzEKoTKAfIosswAQduMOGU4q4elcNr8OE6LoBZcp2MHKalOW835wjRiF6fxVTc7RmBgatKfAt1Qq0heb00rUaCOd2T\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51HuxFUHyGzEKoTKAueAuF9BrMDA5boMcpJLLt0vu4q3QdPX5isaGudKNe6OyVjZP1UugpYd6JA7i7TczRWsbutaP004YmBiSp5\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-12-05 09:49:03'),
(12, 112, 'instamojo', '5f6f1babbdbb31601117099.jpg', 'Instamojo', 1, '{\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_2241633c3bc44a3de84a3b33969\"},\"auth_token\":{\"title\":\"Auth Token\",\"global\":true,\"value\":\"test_279f083f7bebefd35217feef22d\"},\"salt\":{\"title\":\"Salt\",\"global\":true,\"value\":\"19d38908eeff4f58b2ddda2c6d86ca25\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:44:59'),
(13, 501, 'blockchain', '5f6f1b2b20c6f1601116971.jpg', 'Blockchain', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"8df2e5a0-3798-4b74-871d-973615b57e7b\"},\"xpub_code\":{\"title\":\"XPUB CODE\",\"global\":true,\"value\":\"xpub6CXLqfWXj1xgXe79nEQb3pv2E7TGD13pZgHceZKrQAxqXdrC2FaKuQhm5CYVGyNcHLhSdWau4eQvq3EDCyayvbKJvXa11MX9i2cHPugpt3G\"}}', '{\"BTC\":\"BTC\"}', 1, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:42:51'),
(14, 502, 'blockio', '5f6f19432bedf1601116483.jpg', 'Block.io', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":false,\"value\":\"1658-8015-2e5e-9afb\"},\"api_pin\":{\"title\":\"API PIN\",\"global\":true,\"value\":\"covidvai2020\"}}', '{\"BTC\":\"BTC\",\"LTC\":\"LTC\",\"DOGE\":\"DOGE\"}', 1, '{\"cron\":{\"title\": \"Cron URL\",\"value\":\"ipn.blockio\"}}', NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:34:43'),
(15, 503, 'coinpayments', '5f6f1b6c02ecd1601117036.jpg', 'CoinPayments', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"7638eebaf4061b7f7cdfceb14046318bbdabf7e2f64944773d6550bd59f70274\"},\"private_key\":{\"title\":\"Private Key\",\"global\":true,\"value\":\"Cb6dee7af8Eb9E0D4123543E690dA3673294147A5Dc8e7a621B5d484a3803207\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"93a1e014c4ad60a7980b4a7239673cb4\"}}', '{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}', 1, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:43:56'),
(16, 504, 'coinpayments_fiat', '5f6f1b94e9b2b1601117076.jpg', 'CoinPayments Fiat', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"93a1e014c4ad60a7980b4a7239673cb4\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-10-22 03:17:29'),
(17, 505, 'coingate', '5f6f1b5fe18ee1601117023.jpg', 'Coingate', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"Ba1VgPx6d437xLXGKCBkmwVCEw5kHzRJ6thbGo-N\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:43:44'),
(18, 506, 'coinbase_commerce', '5f6f1b4c774af1601117004.jpg', 'Coinbase Commerce', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"c47cd7df-d8e8-424b-a20a\"},\"secret\":{\"title\":\"Webhook Shared Secret\",\"global\":true,\"value\":\"55871878-2c32-4f64-ab66\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"JPY\":\"JPY\",\"GBP\":\"GBP\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CNY\":\"CNY\",\"SEK\":\"SEK\",\"NZD\":\"NZD\",\"MXN\":\"MXN\",\"SGD\":\"SGD\",\"HKD\":\"HKD\",\"NOK\":\"NOK\",\"KRW\":\"KRW\",\"TRY\":\"TRY\",\"RUB\":\"RUB\",\"INR\":\"INR\",\"BRL\":\"BRL\",\"ZAR\":\"ZAR\",\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CDF\":\"CDF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NPR\":\"NPR\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}\r\n\r\n', 0, '{\"endpoint\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.coinbase_commerce\"}}', NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:43:24'),
(24, 113, 'paypal_sdk', '5f6f1bec255c61601117164.jpg', 'Paypal Express', 1, '{\"clientId\":{\"title\":\"Paypal Client ID\",\"global\":true,\"value\":\"Ae0-tixtSV7DvLwIh3Bmu7JvHrjh5EfGdXr_cEklKAVjjezRZ747BxKILiBdzlKKyp-W8W_T7CKH1Ken\"},\"clientSecret\":{\"title\":\"Client Secret\",\"global\":true,\"value\":\"EOhbvHZgFNO21soQJT1L9Q00M3rK6PIEsdiTgXRBt2gtGtxwRer5JvKnVUGNU5oE63fFnjnYY7hq3HBA\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-10-31 23:50:27'),
(25, 114, 'stripe_v3', '5f709684736321601214084.jpg', 'Stripe Checkout', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51HuxFUHyGzEKoTKAfIosswAQduMOGU4q4elcNr8OE6LoBZcp2MHKalOW835wjRiF6fxVTc7RmBgatKfAt1Qq0heb00rUaCOd2T\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51HuxFUHyGzEKoTKAueAuF9BrMDA5boMcpJLLt0vu4q3QdPX5isaGudKNe6OyVjZP1UugpYd6JA7i7TczRWsbutaP004YmBiSp5\"},\"end_point\":{\"title\":\"End Point Secret\",\"global\":true,\"value\":\"w5555\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, '{\"webhook\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.stripe_v3\"}}', NULL, NULL, '2019-09-14 13:14:22', '2020-12-05 09:48:57'),
(27, 115, 'mollie', '5f6f1bb765ab11601117111.jpg', 'Mollie', 1, '{\"mollie_email\":{\"title\":\"Mollie Email \",\"global\":true,\"value\":\"ronniearea@gmail.com\"},\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_cucfwKTWfft9s337qsVfn5CC4vNkrn\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:45:11'),
(31, 116, 'cashmaal', '5f9a8b62bb4dd1603963746.png', 'Cashmaal', 1, '{\"web_id\":{\"title\":\"Web Id\",\"global\":true,\"value\":\"3748\"},\"ipn_key\":{\"title\":\"IPN Key\",\"global\":true,\"value\":\"546254628759524554647987\"}}', '{\"PKR\":\"PKR\",\"USD\":\"USD\"}', 0, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.cashmaal\"}}', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gateway_currencies`
--

CREATE TABLE `gateway_currencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method_code` int(11) DEFAULT NULL,
  `gateway_alias` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_amount` decimal(18,8) NOT NULL,
  `max_amount` decimal(18,8) NOT NULL,
  `percent_charge` decimal(5,2) NOT NULL DEFAULT 0.00,
  `fixed_charge` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_parameter` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sitename` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cur_text` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency symbol',
  `email_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_template` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_api` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_color` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_color` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_config` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'email configuration',
  `sms_config` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'email verification, 0 - dont check, 1 - check',
  `en` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'email notification, 0 - dont send, 1 - send',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'sms verication, 0 - dont check, 1 - check',
  `sn` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'sms notification, 0 - dont send, 1 - send',
  `b_transfer` int(1) NOT NULL DEFAULT 0 COMMENT 'Balance Transfer Status',
  `f_charge` decimal(18,8) NOT NULL DEFAULT 0.00000000 COMMENT 'Fixed Charge',
  `p_charge` decimal(18,8) NOT NULL DEFAULT 0.00000000 COMMENT 'Percent Charge',
  `registration` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Off	, 1: On',
  `social_login` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'social login',
  `social_credential` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_template` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sys_version` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deposit_commission` tinyint(1) NOT NULL DEFAULT 1,
  `invest_commission` tinyint(1) NOT NULL DEFAULT 1,
  `invest_return_commission` tinyint(1) NOT NULL DEFAULT 1,
  `signup_bonus_amount` decimal(11,2) DEFAULT 0.00,
  `signup_bonus_control` tinyint(1) NOT NULL DEFAULT 0,
  `off_day` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_cron` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `sitename`, `cur_text`, `cur_sym`, `email_from`, `email_template`, `sms_api`, `base_color`, `secondary_color`, `mail_config`, `sms_config`, `ev`, `en`, `sv`, `sn`, `b_transfer`, `f_charge`, `p_charge`, `registration`, `social_login`, `social_credential`, `active_template`, `sys_version`, `deposit_commission`, `invest_commission`, `invest_return_commission`, `signup_bonus_amount`, `signup_bonus_control`, `off_day`, `last_cron`, `created_at`, `updated_at`) VALUES
(1, 'HYIPLab', 'USD', '$', 'do-not-reply@email.com', '<table style=\"color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(0, 23, 54); text-decoration-style: initial; text-decoration-color: initial;\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" bgcolor=\"#001736\"><tbody><tr><td valign=\"top\" align=\"center\"><table class=\"mobile-shell\" width=\"650\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"td container\" style=\"width: 650px; min-width: 650px; font-size: 0pt; line-height: 0pt; margin: 0px; font-weight: normal; padding: 55px 0px;\"><div style=\"text-align: center;\"><img src=\"https://i.imgur.com/C9IS7Z1.png\" style=\"height: 240 !important;width: 338px;margin-bottom: 20px;\"></div><table style=\"width: 650px; margin: 0px auto;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td style=\"padding-bottom: 10px;\"><table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"tbrr p30-15\" style=\"padding: 60px 30px; border-radius: 26px 26px 0px 0px;\" bgcolor=\"#000036\"><table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td style=\"color: rgb(255, 255, 255); font-family: Muli, Arial, sans-serif; font-size: 20px; line-height: 46px; padding-bottom: 25px; font-weight: bold;\">Hi {{name}} ,</td></tr><tr><td style=\"color: rgb(193, 205, 220); font-family: Muli, Arial, sans-serif; font-size: 20px; line-height: 30px; padding-bottom: 25px;\">{{message}}</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style=\"width: 650px; margin: 0px auto;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"p30-15 bbrr\" style=\"padding: 50px 30px; border-radius: 0px 0px 26px 26px;\" bgcolor=\"#000036\"><table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"text-footer1 pb10\" style=\"color: rgb(0, 153, 255); font-family: Muli, Arial, sans-serif; font-size: 18px; line-height: 30px; text-align: center; padding-bottom: 10px;\">© 2020 ViserLab. All Rights Reserved.</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>', 'Hi {{name}}, {{message}}', 'CCA354', '000000', '{\"name\":\"php\"}', '{\"api_key\":\"TEST_KEY\",\"api_secret\":\"efsdfsdfg\",\"name\":\"nexmo\"}', 0, 1, 0, 0, 1, '2.00000000', '3.00000000', 1, 0, '{\"google_client_id\":\"53929591142-l40gafo7efd9onfe6tj545sf9g7tv15t.apps.googleusercontent.com\",\"google_client_secret\":\"BRdB3np2IgYLiy4-bwMcmOwN\",\"fb_client_id\":\"277229062999748\",\"fb_client_secret\":\"1acfc850f73d1955d14b282938585122\"}', 'bit_gold', NULL, 1, 1, 1, '10.00', 1, '{\"mon\":\"on\",\"tue\":\"on\",\"wed\":\"on\",\"thu\":\"on\",\"fri\":\"on\",\"sat\":\"on\"}', '2021-06-01 10:23:48', '2020-07-21 01:23:47', '2021-06-01 04:23:48');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `date`, `created_at`, `updated_at`) VALUES
(4, '2021-06-02', '2021-05-29 06:58:21', '2021-05-29 06:58:21'),
(5, '2021-06-03', '2021-05-29 06:58:35', '2021-05-29 06:58:35'),
(6, '2021-07-07', '2021-06-01 10:16:29', '2021-06-01 10:16:29');

-- --------------------------------------------------------

--
-- Table structure for table `invests`
--

CREATE TABLE `invests` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `amount` decimal(11,2) NOT NULL DEFAULT 0.00,
  `interest` decimal(11,2) NOT NULL DEFAULT 0.00,
  `period` int(11) NOT NULL,
  `hours` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_rec_time` int(11) NOT NULL DEFAULT 0,
  `next_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_time` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `capital_status` tinyint(1) NOT NULL COMMENT '1 = YES & 0 = NO',
  `trx` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_align` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: left to right text align, 1: right to left text align',
  `is_default` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: not default language, 1: default language',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `icon`, `text_align`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', NULL, 0, 1, '2020-12-07 16:15:09', '2020-12-07 16:15:09');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_06_14_061757_create_support_tickets_table', 3),
(5, '2020_06_14_061837_create_support_messages_table', 3),
(6, '2020_06_14_061904_create_support_attachments_table', 3),
(7, '2020_06_14_062359_create_admins_table', 3),
(8, '2020_06_14_064604_create_transactions_table', 4),
(9, '2020_06_14_065247_create_general_settings_table', 5),
(12, '2014_10_12_100000_create_password_resets_table', 6),
(13, '2020_06_14_060541_create_user_logins_table', 6),
(14, '2020_06_14_071708_create_admin_password_resets_table', 7),
(15, '2019_12_14_000001_create_personal_access_tokens_table', 8),
(16, '2021_05_27_023755_create_promotion_tools_table', 8),
(17, '2021_05_27_115955_create_admin_notifications_table', 9),
(18, '2021_05_29_121404_create_holidays_table', 10),
(19, '2021_05_29_153113_create_email_logs_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'template name',
  `secs` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `tempname`, `secs`, `is_default`, `created_at`, `updated_at`) VALUES
(4, 'HOME', 'home', 'templates.neo_dark.', '[\"about\",\"faq\",\"feature\",\"plan\",\"subscribe\",\"testimonial\",\"top_investor\",\"transaction\",\"blog\",\"calculation\"]', 1, '2020-08-29 11:06:15', '2020-12-07 12:49:22'),
(5, 'About Us', 'about', 'templates.neo_dark.', '[\"how_work\",\"about\",\"counter\",\"team\",\"we_accept\"]', 0, '2020-08-30 16:05:48', '2020-12-07 12:50:06'),
(7, 'HOME', 'home', 'templates.bit_gold.', '[\"about\",\"plan\",\"why_choose\",\"calculation\",\"how_work\",\"faq\",\"testimonial\",\"team\",\"transaction\",\"top_investor\",\"cta\",\"we_accept\",\"blog\",\"subscribe\"]', 1, '2020-11-29 08:45:29', '2020-12-07 12:47:36'),
(8, 'About', 'about', 'templates.bit_gold.', '[\"how_work\",\"about\",\"faq\",\"cta\"]', 0, '2020-11-30 10:27:10', '2020-11-30 10:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('user@site.com', '668191', '2021-05-29 09:06:08');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minimum` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maximum` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fixed_amount` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `interest` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `interest_status` int(11) NOT NULL COMMENT '1 = ''%'' / 0 =''currency''',
  `times` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `featured` tinyint(4) NOT NULL DEFAULT 0,
  `capital_back_status` int(11) NOT NULL,
  `lifetime_status` int(11) NOT NULL,
  `repeat_time` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plugins`
--

CREATE TABLE `plugins` (
  `id` int(10) UNSIGNED NOT NULL,
  `act` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `script` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortcode` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'object',
  `support` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plugins`
--

INSERT INTO `plugins` (`id`, `act`, `name`, `description`, `image`, `script`, `shortcode`, `support`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'tawk-chat', 'Tawk.to', 'Key location is shown bellow', 'tawky_big.png', '<script>\n                        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\n                        (function(){\n                        var s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\n                        s1.async=true;\n                        s1.src=\"https://embed.tawk.to/{{app_key}}\";\n                        s1.charset=\"UTF-8\";\n                        s1.setAttribute(\"crossorigin\",\"*\");\n                        s0.parentNode.insertBefore(s1,s0);\n                        })();\n                    </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"----\"}}', 'twak.png', 0, NULL, '2019-10-18 23:16:05', '2021-05-27 05:58:32'),
(2, 'google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'recaptcha3.png', '\r\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\r\n<div class=\"g-recaptcha\" data-sitekey=\"{{sitekey}}\" data-callback=\"verifyCaptcha\"></div>\r\n<div id=\"g-recaptcha-error\"></div>', '{\"sitekey\":{\"title\":\"Site Key\",\"value\":\"KEY\"}}', 'recaptcha.png', 0, NULL, '2019-10-18 23:16:05', '2020-11-30 07:15:29'),
(3, 'custom-captcha', 'Custom Captcha', 'Just Put Any Random String', 'customcaptcha.png', NULL, '{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureString\"}}', 'na', 1, NULL, '2019-10-18 23:16:05', '2020-12-07 10:45:13'),
(4, 'google-analytics', 'Google Analytics', 'Key location is shown bellow', 'google-analytics.png', '<script async src=\"https://www.googletagmanager.com/gtag/js?id={{app_key}}\"></script>\r\n                <script>\r\n                  window.dataLayer = window.dataLayer || [];\r\n                  function gtag(){dataLayer.push(arguments);}\r\n                  gtag(\"js\", new Date());\r\n                \r\n                  gtag(\"config\", \"{{app_key}}\");\r\n                </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"UA-00000\"}}', 'ganalytics.png', 0, NULL, NULL, '2020-12-07 10:45:26'),
(5, 'fb-comment', 'Facebook Comment ', 'Key location is shown bellow', 'Facebook.png', '<div id=\"fb-root\"></div><script async defer crossorigin=\"anonymous\" src=\"https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v4.0&appId={{app_key}}&autoLogAppEvents=1\"></script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"713047905830100\"}}', 'fb_com.PNG', 0, NULL, NULL, '2020-12-07 10:45:17');

-- --------------------------------------------------------

--
-- Table structure for table `promotion_tools`
--

CREATE TABLE `promotion_tools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` int(10) UNSIGNED NOT NULL,
  `commission_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL,
  `percent` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_attachments`
--

CREATE TABLE `support_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_message_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supportticket_id` int(11) DEFAULT NULL,
  `admin_id` int(11) NOT NULL DEFAULT 0,
  `message` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(91) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed',
  `last_reply` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_settings`
--

CREATE TABLE `time_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `time_settings`
--

INSERT INTO `time_settings` (`id`, `name`, `time`, `created_at`, `updated_at`) VALUES
(1, 'Hour', '1', '2020-11-05 06:48:07', '2020-11-26 15:31:08'),
(2, 'Day', '24', '2020-11-05 06:48:07', '2020-11-26 15:31:22'),
(3, 'Week', '168', '2020-11-05 06:48:07', '2020-11-26 15:31:16'),
(4, 'Month', '720', '2020-11-05 06:48:07', '2020-11-26 15:31:26'),
(5, 'Year', '8760', '2020-11-05 06:48:07', '2020-11-26 15:31:29');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `post_balance` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `trx_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wallet_type` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_by` int(11) DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(91) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'contains full address',
  `deposit_wallet` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `interest_wallet` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: banned, 1: active',
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: sms unverified, 1: sms verified',
  `ver_code` varchar(91) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `ts` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: 2fa off, 1: 2fa on',
  `tv` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: 2fa unverified, 1: 2fa verified',
  `tsc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_ip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(91) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` int(10) UNSIGNED NOT NULL,
  `method_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(18,8) NOT NULL,
  `currency` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(18,8) NOT NULL,
  `charge` decimal(18,8) NOT NULL,
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `final_amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `after_charge` decimal(18,8) NOT NULL,
  `withdraw_information` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel,  ',
  `admin_feedback` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_methods`
--

CREATE TABLE `withdraw_methods` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_limit` decimal(18,8) DEFAULT NULL,
  `max_limit` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `delay` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fixed_charge` decimal(18,8) DEFAULT NULL,
  `rate` decimal(18,8) DEFAULT NULL,
  `percent_charge` decimal(5,2) DEFAULT NULL,
  `currency` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD UNIQUE KEY `admins_username_unique` (`username`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commission_logs`
--
ALTER TABLE `commission_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_sms_templates`
--
ALTER TABLE `email_sms_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_sms_templates_act_unique` (`act`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `frontends_key_index` (`data_keys`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invests`
--
ALTER TABLE `invests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plugins`
--
ALTER TABLE `plugins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plugins_act_unique` (`act`);

--
-- Indexes for table `promotion_tools`
--
ALTER TABLE `promotion_tools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_attachments`
--
ALTER TABLE `support_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_settings`
--
ALTER TABLE `time_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `withdrawals_trx_unique` (`trx`);

--
-- Indexes for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commission_logs`
--
ALTER TABLE `commission_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `email_sms_templates`
--
ALTER TABLE `email_sms_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `invests`
--
ALTER TABLE `invests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plugins`
--
ALTER TABLE `plugins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `promotion_tools`
--
ALTER TABLE `promotion_tools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_attachments`
--
ALTER TABLE `support_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_settings`
--
ALTER TABLE `time_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
