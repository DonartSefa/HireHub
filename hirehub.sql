-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 24. Mai 2025 um 22:04
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `hirehub`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `education_level` varchar(100) DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `applications`
--

INSERT INTO `applications` (`id`, `user_id`, `job_id`, `full_name`, `email`, `phone`, `gender`, `city`, `dob`, `education_level`, `experience`, `applied_at`) VALUES
(2, 2, 179, 'Donart Sefa', 'donart', '04444444', 'Female', 'Prishtine', '1962-04-02', 'Master\'s', '3 - 5 years', '2025-05-24 14:23:24');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `company`, `description`, `location`, `category`, `posted_by`, `created_at`, `image`) VALUES
(175, 'Web Developer', 'PixelTech', 'Build and maintain web apps.', 'New York, NY', 'IT', 1, '2025-05-24 13:29:10', 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=300'),
(176, 'Data Scientist', 'DataZone', 'Analyze data for trends.', 'Chicago, IL', 'Data', 2, '2025-05-24 13:29:10', 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=300'),
(177, 'Marketing Manager', 'Brandwise', 'Lead marketing strategies.', 'Austin, TX', 'Marketing', 3, '2025-05-24 13:29:10', 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=300'),
(178, 'Graphic Designer', 'DesignHive', 'Create branding visuals.', 'San Diego, CA', 'Design', 4, '2025-05-24 13:29:10', 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=300'),
(179, 'Backend Developer', 'ByteCraft', 'Develop scalable backend systems and APIs.', 'New York, NY', 'IT', 1, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=400&h=300&fit=crop'),
(180, 'UI/UX Designer', 'PixelSoft', 'Design clean and user-friendly interfaces.', 'Los Angeles, CA', 'Design', 2, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1559027615-5c2c6987c1f1?w=400&h=300&fit=crop'),
(181, 'Data Scientist', 'DeepData', 'Analyze data and build predictive models.', 'San Francisco, CA', 'Data Science', 3, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=400&h=300&fit=crop'),
(182, 'Marketing Lead', 'BrandNest', 'Lead digital marketing campaigns.', 'Chicago, IL', 'Marketing', 1, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1556740738-b6a63e27c4df?w=400&h=300&fit=crop'),
(183, 'HR Manager', 'PeopleFirst', 'Oversee HR operations and recruitment.', 'Austin, TX', 'Human Resources', 2, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=400&h=300&fit=crop'),
(184, 'Project Coordinator', 'TechSync', 'Coordinate cross-team software projects.', 'Denver, CO', 'Management', 3, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1527689368864-3a821dbccc34?w=400&h=300&fit=crop'),
(185, 'DevOps Engineer', 'CloudOps', 'Manage CI/CD pipelines and cloud infrastructure.', 'Seattle, WA', 'IT', 1, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=400&h=300&fit=crop'),
(186, 'Copywriter', 'WriteLab', 'Write compelling content for various platforms.', 'Remote', 'Content', 2, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=400&h=300&fit=crop'),
(187, 'Frontend Developer', 'DesignCode', 'Develop user-facing features using React.', 'Boston, MA', 'IT', 3, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1517430816045-df4b7de11d1b?w=400&h=300&fit=crop'),
(188, 'Account Manager', 'BizGrowth', 'Manage key client accounts and growth.', 'Miami, FL', 'Sales', 1, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=400&h=300&fit=crop'),
(189, 'Technical Writer', 'DocuPro', 'Create technical manuals and guides.', 'Atlanta, GA', 'Documentation', 2, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1573497019440-cb1f27d1e5da?w=400&h=300&fit=crop'),
(190, 'Recruiter', 'HireWise', 'Source and screen candidates for roles.', 'Philadelphia, PA', 'Human Resources', 3, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1581092919537-4f1f2c08b4d3?w=400&h=300&fit=crop'),
(191, 'QA Engineer', 'BugHunt', 'Test and ensure software quality.', 'San Diego, CA', 'IT', 1, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1531497865146-76a1e64eac2c?w=400&h=300&fit=crop'),
(192, 'Social Media Manager', 'ViralWaves', 'Plan and execute social media strategy.', 'Remote', 'Marketing', 2, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1508780709619-79562169bc64?w=400&h=300&fit=crop'),
(193, 'Mobile Developer', 'AppForge', 'Develop mobile apps for iOS and Android.', 'Portland, OR', 'IT', 3, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1519241047957-be31d7379a5d?w=400&h=300&fit=crop'),
(194, 'Legal Advisor', 'LegalEase', 'Advise the company on legal matters.', 'Washington, DC', 'Legal', 1, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1573164574392-9d1ec9f8e99c?w=400&h=300&fit=crop'),
(195, 'Customer Support Rep', 'SupportSphere', 'Resolve customer issues and inquiries.', 'Phoenix, AZ', 'Customer Service', 2, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1581093588401-9c79ae1d93c2?w=400&h=300&fit=crop'),
(196, 'Business Analyst', 'InsightPro', 'Analyze business processes and suggest improvements.', 'Columbus, OH', 'Business', 3, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1516321165247-4aa89a48be28?w=400&h=300&fit=crop'),
(197, 'SEO Specialist', 'RankBoost', 'Improve website ranking and traffic.', 'Dallas, TX', 'Marketing', 1, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1520880867055-1e30d1cb001c?w=400&h=300&fit=crop'),
(198, 'Graphic Artist', 'VisualHive', 'Create marketing visuals and graphics.', 'San Jose, CA', 'Design', 2, '2025-05-24 13:33:37', 'https://images.unsplash.com/photo-1531497865146-76a1e64eac2c?w=400&h=300&fit=crop');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('employer','job_seeker') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `user_type`, `created_at`) VALUES
(1, 'donart', 'donart@gmail.com', '$2y$10$YhdFVqQDzfagUmQPHpoXL.QHB/Qz6jUCzR27ypGZouqBm2eV.zRaW', 'employer', '2025-05-24 08:24:09'),
(2, 'diar', 'diar@gmail.com', '$2y$10$zSz9FajDpIcwvMLwu6Tk4.XdYij7UR.UNJVpVVx2sa2CYuxHW0rgu', 'job_seeker', '2025-05-24 08:25:01'),
(3, 'alice', 'alice@example.com', 'password_hash', 'employer', '2025-05-24 12:48:42'),
(4, 'bob', 'bob@example.com', 'password_hash', 'employer', '2025-05-24 12:48:42'),
(5, 'charlie', 'charlie@example.com', 'password_hash', 'employer', '2025-05-24 12:48:42'),
(6, 'employer1', 'employer1@example.com', 'password123', 'employer', '2025-05-24 13:16:53'),
(7, 'employer2', 'employer2@example.com', 'password123', 'employer', '2025-05-24 13:16:53'),
(8, 'jobseeker1', 'jobseeker1@example.com', 'password123', 'job_seeker', '2025-05-24 13:16:53'),
(9, 'jobseeker2', 'jobseeker2@example.com', 'password123', 'job_seeker', '2025-05-24 13:16:53'),
(10, 'admin', 'admin@example.com', 'password123', '', '2025-05-24 13:16:53');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indizes für die Tabelle `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posted_by` (`posted_by`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`posted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
