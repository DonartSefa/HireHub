-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 25. Mai 2025 um 20:41
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
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `applications`
--

INSERT INTO `applications` (`id`, `user_id`, `job_id`, `full_name`, `email`, `phone`, `gender`, `city`, `dob`, `education_level`, `experience`, `applied_at`, `status`) VALUES
(4, 2, 201, 'lorent imeri', 'lorent@gmail.com', '3333333', 'Male', 'Prishtine', '2000-11-15', 'Bachelor\'s', 'More than 5 years', '2025-05-25 14:06:05', 'denied'),
(5, 2, 202, 'lorent donart', 'diar@gmail.com', '33333', 'Male', 'Prishtine', '1967-10-10', 'High School', 'More than 5 years', '2025-05-25 14:08:04', 'Pending');

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
  `image` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `company`, `description`, `location`, `category`, `posted_by`, `created_at`, `image`, `detail`) VALUES
(201, 'Web Developer', 'PixelTech', 'Build and maintain web apps.', 'New York, NY', 'IT', 1, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=300', 'Compensation: $70,000 per year  \r\nSchedule: Monday–Friday, 9:00 AM – 5:00 PM  \r\nWork Type: On-site with occasional remote flexibility  \r\nBenefits: Health, dental, and vision insurance, 401(k) with matching  \r\nPerks: Monthly team lunches, professional development budget  \r\nEnvironment: Collaborative agile team, regular code reviews'),
(202, 'Data Scientist', 'DataZone', 'Analyze data for trends.', 'Chicago, IL', 'Data', 2, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=300', 'Compensation: $95,000–$105,000/year depending on experience  \r\nSchedule: Flexible hours with core availability 11 AM – 4 PM  \r\nRemote Policy: Fully remote, office optional  \r\nBenefits: Stock options, health/dental/vision, yearly conference stipend  \r\nTools: Python, SQL, TensorFlow, Tableau  \r\nTeam: Cross-functional data & product squads'),
(203, 'Marketing Manager', 'Brandwise', 'Lead marketing strategies.', 'Austin, TX', 'Marketing', 3, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=300', 'Salary: $85,000 base + performance bonus  \r\nWork Hours: Standard business hours, some evening campaign launches  \r\nContract Type: Full-time permanent  \r\nPerks: Wellness programs, mental health days, remote Fridays  \r\nTools: HubSpot, Google Ads, Slack, Monday.com  \r\nTeam: 5-person team, collaborative with sales and product'),
(204, 'Graphic Designer', 'DesignHive', 'Create branding visuals.', 'San Diego, CA', 'Design', 4, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=300', 'Rate: $30/hour on a 6-month renewable contract  \r\nWorkload: 25–30 hours/week, remote  \r\nTools: Adobe CC (Photoshop, Illustrator), Figma  \r\nExtras: Laptop provided, software licenses covered  \r\nExpectations: Weekly check-ins, design revisions, branding workshops'),
(205, 'Backend Developer', 'ByteCraft', 'Develop backend systems and APIs.', 'New York, NY', 'IT', 1, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=400', 'Annual Salary: $100,000  \r\nHours: Flexible, expected availability 10am–4pm  \r\nEnvironment: Remote-first, GitHub + Slack-based  \r\nStack: Node.js, PostgreSQL, Docker, AWS  \r\nPerks: 20 PTO days, company equity, $1,000 home office stipend'),
(206, 'UI/UX Designer', 'PixelSoft', 'Design user interfaces.', 'Los Angeles, CA', 'Design', 2, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1559027615-5c2c6987c1f1?w=400', 'Salary: $75,000 annually  \r\nSchedule: 9–5 with optional 4-day workweek  \r\nRemote Work: Hybrid (3 days remote)  \r\nExtras: Gym membership, lunch stipend, design conferences  \r\nTeam Size: Small product squad of 3–4 designers'),
(207, 'Data Scientist', 'DeepData', 'Predictive model development.', 'San Francisco, CA', 'Data Science', 3, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=400', 'Pay: $110,000/year + stock equity  \r\nSchedule: Flexible, async-first  \r\nPerks: Work-from-anywhere, AI/ML conference trips, sabbatical after 4 years  \r\nTools: Jupyter, Pandas, Snowflake, PyTorch'),
(208, 'Marketing Lead', 'BrandNest', 'Oversee digital campaigns.', 'Chicago, IL', 'Marketing', 1, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1556740738-b6a63e27c4df?w=400', 'Compensation: $80,000/year + annual performance bonus  \r\nWork Mode: Hybrid (2–3 days remote)  \r\nIncentives: Annual retreat, brand ownership share  \r\nCareer Path: Director opportunity in 2 years'),
(209, 'HR Manager', 'PeopleFirst', 'Manage HR ops.', 'Austin, TX', 'Human Resources', 2, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=400', 'Salary: $88,000  \r\nHours: Mon–Fri, standard 40h  \r\nBenefits: Full medical, vision, dental, maternity leave  \r\nTools: BambooHR, Greenhouse, GSuite  \r\nCulture: DEI-focused, high employee satisfaction'),
(210, 'Project Coordinator', 'TechSync', 'Coordinate agile teams.', 'Denver, CO', 'Management', 3, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1527689368864-3a821dbccc34?w=400', 'Pay: $68,000  \r\nLocation: Hybrid or in-office  \r\nPerks: Free public transport pass, coworking budget, health coverage  \r\nTeam: Works with devs, testers, and product owners'),
(211, 'DevOps Engineer', 'CloudOps', 'Manage CI/CD pipelines.', 'Seattle, WA', 'IT', 1, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=400', 'Salary: $105,000/year  \r\nRemote: Fully remote  \r\nStack: AWS, Terraform, Jenkins, Kubernetes  \r\nOther: $2,000 learning allowance, paid parental leave'),
(212, 'Copywriter', 'WriteLab', 'Create blog posts & ads.', 'Remote', 'Content', 2, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=400', 'Pay: $25/hour  \r\nFlexibility: 100% remote, async  \r\nExtras: Free Grammarly Pro, editorial coaching, weekly writing prompts'),
(213, 'Frontend Developer', 'DesignCode', 'Implement UI using React.', 'Boston, MA', 'IT', 3, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1517430816045-df4b7de11d1b?w=400', 'Annual Salary: $90,000  \r\nPerks: Equity, bi-weekly sprints, wellness budget  \r\nTech Stack: React, Tailwind, TypeScript, GraphQL'),
(214, 'Account Manager', 'BizGrowth', 'Client success management.', 'Miami, FL', 'Sales', 1, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=400', 'Comp: $60,000 base + up to $30,000 commissions  \r\nTravel: ~25% domestic travel  \r\nSupport: Dedicated SDR + CRM tools'),
(215, 'Technical Writer', 'DocuPro', 'Author user manuals.', 'Atlanta, GA', 'Documentation', 2, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1573497019440-cb1f27d1e5da?w=400', 'Rate: $40/hour, 10-month contract  \r\nBenefits: Freelance-friendly, invoice-based  \r\nDocs: API references, onboarding guides, internal docs'),
(216, 'Recruiter', 'HireWise', 'Talent acquisition.', 'Philadelphia, PA', 'HR', 3, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1581092919537-4f1f2c08b4d3?w=400', 'Pay: $70,000 base + bonus per hire  \r\nLocation: Remote with some travel  \r\nTools: LinkedIn Recruiter, ATS, Calendly'),
(217, 'QA Engineer', 'BugHunt', 'Test software.', 'San Diego, CA', 'IT', 1, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1531497865146-76a1e64eac2c?w=400', 'Salary: $85,000/year  \r\nSchedule: 4-day workweek option  \r\nExtras: Device lab access, bug bounty program'),
(218, 'Social Media Manager', 'ViralWaves', 'Social media content.', 'Remote', 'Marketing', 2, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1508780709619-79562169bc64?w=400', 'Pay: $20/hour  \r\nWork Type: Freelance, 10–20 hrs/week  \r\nTools: Buffer, Canva, TikTok, Meta Business Suite'),
(219, 'Mobile Developer', 'AppForge', 'Build mobile apps.', 'Portland, OR', 'IT', 3, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1519241047957-be31d7379a5d?w=400', 'Annual: $100,000 + bonus  \r\nRemote: Hybrid or fully remote  \r\nTech: Flutter, React Native, Firebase'),
(220, 'Legal Advisor', 'LegalEase', 'Corporate legal guidance.', 'Washington, DC', 'Legal', 1, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1573164574392-9d1ec9f8e99c?w=400', 'Pay: $120,000/year  \r\nWorkload: Full-time, in-house  \r\nBenefits: Legal insurance, CLE reimbursement, private office');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

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
