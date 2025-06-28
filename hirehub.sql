-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2025 at 12:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hirehub`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
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
  `resume_path` varchar(255) DEFAULT NULL,
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `user_id`, `job_id`, `full_name`, `email`, `phone`, `gender`, `city`, `dob`, `education_level`, `experience`, `resume_path`, `applied_at`, `status`) VALUES
(1, 5, 1, 'Job Seeker One', 'jobseeker1@example.com', '555-2222', 'Male', 'Austin', '1995-05-15', 'Bachelor\'s Degree', '2 years of marketing experience', '/path/to/resume.pdf', '2025-05-25 12:21:55', 'Pending'),
(2, 6, 2, 'Job Seeker Two', 'jobseeker2@example.com', '555-4444', 'Female', 'San Diego', '1993-09-22', 'Master\'s Degree', '3 years of design experience', '/path/to/resume2.pdf', '2025-05-25 12:22:10', 'Pending'),
(3, 7, 6, 'Job Seeker Three', 'jobseeker3@example.com', '555-6666', 'Female', 'Seattle', '1990-02-10', 'Master\'s Degree', '5 years of UI/UX design experience', '/path/to/resume3.pdf', '2025-06-10 14:30:00', 'Pending'),
(4, 8, 7, 'Job Seeker Four', 'jobseeker4@example.com', '555-7777', 'Male', 'San Francisco', '1988-03-05', 'Bachelor\'s Degree', '4 years of backend development experience', '/path/to/resume4.pdf', '2025-06-15 09:00:00', 'Pending'),
(5, 10, 76, 'Donart Sefa', 'donart@gmail.com', '0332222', 'Male', 'Prishtine', '1998-01-12', 'High School', 'Less than 1 year', NULL, '2025-06-28 10:13:13', 'Pending'),
(6, 10, 75, 'Donart Sefa', 'donart@gmail.com', '0332222', 'Male', 'Prishtina', '1995-02-15', 'Bachelor\'s', '3 - 5 years', 'uploads/resumes/resume_685fc050702c03.53966252.pdf', '2025-06-28 10:13:36', 'Pending'),
(7, 10, 69, 'Diar Berisha', 'diar@gmail.com', '1321231231', 'Male', 'Prishtina', '2005-01-12', 'Master\'s', '1 - 3 years', NULL, '2025-06-28 10:18:43', 'Pending'),
(8, 10, 69, 'Diar Berisha', 'diar@gmail.com', '0332222', 'Female', 'Prishtine', '2007-02-03', 'Bachelor\'s', '3 - 5 years', 'uploads/resumes/resume_685fc199a72600.85247704.pdf', '2025-06-28 10:19:05', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
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
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `company`, `description`, `location`, `category`, `posted_by`, `created_at`, `image`, `detail`) VALUES
(1, 'Marketing Manager', 'Brandwise', 'Lead marketing strategies.', 'Austin, TX', 'Marketing', 4, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=300', 'Salary: $85,000 base + performance bonus  \nWork Hours: Standard business hours, some evening campaign launches  \nContract Type: Full-time permanent  \nPerks: Wellness programs, mental health days, remote Fridays  \nTools: HubSpot, Google Ads, Slack, Monday.com  \nTeam: 5-person team, collaborative with sales and product'),
(2, 'Graphic Designer', 'DesignHive', 'Create branding visuals.', 'San Diego, CA', 'Design', 4, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=300', 'Rate: $30/hour on a 6-month renewable contract  \r\nWorkload: 25â€“30 hours/week, remote  \r\nTools: Adobe CC (Photoshop, Illustrator), Figma  \r\nExtras: Laptop provided, software licenses covered  \r\nExpectations: Weekly check-ins, design revisions, branding workshops'),
(3, 'Data Scientist', 'DeepData', 'Predictive model development.', 'San Francisco, CA', 'Data Science', 3, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=400', 'Pay: $110,000/year + stock equity  \r\nSchedule: Flexible, async-first  \r\nPerks: Work-from-anywhere, AI/ML conference trips, sabbatical after 4 years  \r\nTools: Jupyter, Pandas, Snowflake, PyTorch'),
(4, 'Project Coordinator', 'TechSync', 'Coordinate agile teams.', 'Denver, CO', 'Management', 4, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1527689368864-3a821dbccc34?w=400', 'Pay: $68,000  \r\nLocation: Hybrid or in-office  \r\nPerks: Free public transport pass, coworking budget, health coverage  \r\nTeam: Works with devs, testers, and product owners'),
(5, 'Frontend Developer', 'DesignCode', 'Implement UI using React.', 'Boston, MA', 'IT', 4, '2025-05-25 12:21:55', 'https://images.unsplash.com/photo-1517430816045-df4b7de11d1b?w=400', 'Annual Salary: $90,000  \r\nPerks: Equity, bi-weekly sprints, wellness budget  \r\nTech Stack: React, Tailwind, TypeScript, Jest'),
(6, 'Backend Developer', 'TechWorks', 'Develop backend services with Node.js', 'Los Angeles, CA', 'IT', 5, '2025-06-01 10:00:00', 'https://images.unsplash.com/photo-1493665104056-0f7e75d02f27?w=500', 'Annual Salary: $95,000 \r\nTech Stack: Node.js, Express, MongoDB, Docker \r\nPerks: Flexible hours, free lunch, remote-friendly'),
(7, 'UX/UI Designer', 'CreativeTech', 'Design user experiences and interfaces', 'Seattle, WA', 'Design', 6, '2025-06-15 12:00:00', 'https://images.unsplash.com/photo-1531495028345-7f19f2db92b8?w=400', 'Salary: $75,000/year \r\nTools: Figma, Adobe XD, Sketch \r\nPerks: Health benefits, annual bonus, remote options'),
(53, 'Web Developer', 'Tech Innovators', 'Develop dynamic websites and web applications.', 'New York, NY', 'IT', 9, '2025-06-28 10:00:00', 'https://images.unsplash.com/photo-1603784567225-fc1c2b2041bb?w=300', 'Salary: $80,000/year\nPerks: Health insurance, Remote options\nTools: HTML, CSS, JavaScript, React'),
(54, 'Mobile App Developer', 'AppWorks', 'Develop mobile applications for iOS and Android.', 'Los Angeles, CA', 'IT', 9, '2025-06-28 10:05:00', 'https://images.unsplash.com/photo-1603784567225-fc1c2b2041bb?w=300', 'Salary: $90,000/year\nPerks: Flexible working hours, Paid time off\nTools: Flutter, Java, Swift'),
(55, 'Software Engineer', 'NextGen Software', 'Develop scalable software solutions for clients.', 'Chicago, IL', 'IT', 9, '2025-06-28 10:10:00', 'https://images.unsplash.com/photo-1555685817-457d4a415a1f?w=300', 'Salary: $95,000/year\nPerks: Career development, 401k matching\nTools: Java, Spring Boot, AWS'),
(56, 'Data Scientist', 'DataVision', 'Analyze and interpret complex data to aid decision-making.', 'San Francisco, CA', 'Data Science', 9, '2025-06-28 10:15:00', 'https://images.unsplash.com/photo-1541886731-3d3137bb8b0d?w=300', 'Salary: $110,000/year\nPerks: Health insurance, Remote Fridays\nTools: Python, R, SQL'),
(57, 'Project Manager', 'ProLead Solutions', 'Manage the project lifecycle from inception to completion.', 'Austin, TX', 'Management', 9, '2025-06-28 10:20:00', 'https://images.unsplash.com/photo-1567464811-b5242630f1be?w=300', 'Salary: $85,000/year\nPerks: Free lunch, flexible hours\nTools: Jira, Trello, MS Project'),
(58, 'UX/UI Designer', 'Design Innovations', 'Create user-friendly designs for websites and mobile apps.', 'Boston, MA', 'Design', 9, '2025-06-28 10:25:00', 'https://images.unsplash.com/photo-1570191112120-3be4eabbd2e0?w=300', 'Salary: $70,000/year\nPerks: Flexible schedule, remote work\nTools: Figma, Adobe XD'),
(59, 'Frontend Developer', 'DevMasters', 'Build responsive and user-friendly web interfaces.', 'Seattle, WA', 'IT', 9, '2025-06-28 10:30:00', 'https://images.unsplash.com/photo-1570191112120-3be4eabbd2e0?w=300', 'Salary: $75,000/year\nPerks: Gym membership, wellness programs\nTools: React, Angular, CSS3'),
(60, 'Backend Developer', 'CoreTech Solutions', 'Build and maintain the backend systems for web applications.', 'Denver, CO', 'IT', 9, '2025-06-28 10:35:00', 'https://images.unsplash.com/photo-1541891674-ded83acaf028?w=300', 'Salary: $95,000/year\nPerks: Stock options, medical benefits\nTools: Node.js, Python, MongoDB'),
(61, 'Graphic Designer', 'Creative Spark', 'Design visual content for marketing and branding.', 'Miami, FL', 'Design', 9, '2025-06-28 10:40:00', 'https://images.unsplash.com/photo-1533871595613-0a39ec5042f2?w=300', 'Salary: $60,000/year\nPerks: Paid time off, creative freedom\nTools: Adobe Illustrator, Photoshop'),
(62, 'Full Stack Developer', 'CodeFactory', 'Work across the full stack to build cutting-edge web applications.', 'Dallas, TX', 'IT', 9, '2025-06-28 10:45:00', 'https://images.unsplash.com/photo-1596495577883-9f7d6027f29f?w=300', 'Salary: $100,000/year\nPerks: Health coverage, team-building events\nTools: JavaScript, React, Node.js'),
(63, 'Cloud Engineer', 'CloudScape', 'Design and maintain cloud infrastructure.', 'Austin, TX', 'IT', 9, '2025-06-28 10:50:00', 'https://images.unsplash.com/photo-1597496991092-cd5b5c5e83a9?w=300', 'Salary: $120,000/year\nPerks: Remote work, unlimited PTO\nTools: AWS, GCP, Azure'),
(64, 'SEO Specialist', 'RankUp', 'Optimize website content for search engine visibility.', 'Chicago, IL', 'Marketing', 9, '2025-06-28 10:55:00', 'https://images.unsplash.com/photo-1536265663354-029418056f3f?w=300', 'Salary: $55,000/year\nPerks: Health benefits, paid holidays\nTools: Google Analytics, SEMrush, Moz'),
(65, 'Product Manager', 'Productify', 'Manage the development of new products and features.', 'San Francisco, CA', 'Management', 9, '2025-06-28 11:00:00', 'https://images.unsplash.com/photo-1558488767-2ca8b5b0f5fe?w=300', 'Salary: $115,000/year\nPerks: Stock options, flexible working\nTools: Jira, Confluence'),
(66, 'HR Specialist', 'HR Solutions', 'Manage recruitment and employee relations.', 'New York, NY', 'HR', 9, '2025-06-28 11:05:00', 'https://images.unsplash.com/photo-1597801999372-d739ff76e8f0?w=300', 'Salary: $50,000/year\nPerks: Employee discounts, wellness programs\nTools: Workday, BambooHR'),
(67, 'Data Analyst', 'Insight Analytics', 'Analyze and report data trends to support business decisions.', 'Los Angeles, CA', 'Data Science', 9, '2025-06-28 11:10:00', 'https://images.unsplash.com/photo-1529221907952-16b7ab8e7c51?w=300', 'Salary: $65,000/year\nPerks: Paid time off, team activities\nTools: SQL, Python, Excel'),
(68, 'Business Analyst', 'Visionary Consulting', 'Work with stakeholders to gather and analyze business requirements.', 'Seattle, WA', 'Consulting', 9, '2025-06-28 11:15:00', 'https://images.unsplash.com/photo-1584539285689-62e1c5c8e79a?w=300', 'Salary: $70,000/year\nPerks: Career development, team-building retreats\nTools: Jira, Confluence, MS Excel'),
(69, 'Digital Marketing Specialist', 'DigitalWave', 'Create and implement digital marketing strategies.', 'Chicago, IL', 'Marketing', 9, '2025-06-28 11:20:00', 'https://images.unsplash.com/photo-1571796012451-1f06c03bc1f2?w=300', 'Salary: $60,000/year\nPerks: Remote options, health coverage\nTools: Google Ads, Facebook Ads'),
(70, 'Video Producer', 'VidLab', 'Create engaging video content for online platforms.', 'Miami, FL', 'Media', 9, '2025-06-28 11:25:00', 'https://images.unsplash.com/photo-1521141977554-48a96ba22b1e?w=300', 'Salary: $70,000/year\nPerks: Flexible hours, creative freedom\nTools: Adobe Premiere, Final Cut Pro'),
(71, 'Network Engineer', 'NetTech Solutions', 'Design and maintain networking infrastructure.', 'Denver, CO', 'IT', 9, '2025-06-28 11:30:00', 'https://images.unsplash.com/photo-1566202077-b72b59be7fdb?w=300', 'Salary: $85,000/year\nPerks: 401k matching, remote work\nTools: Cisco, Juniper, TCP/IP'),
(72, 'Database Administrator', 'DBExperts', 'Manage and optimize databases for enterprise clients.', 'Boston, MA', 'IT', 9, '2025-06-28 11:35:00', 'https://images.unsplash.com/photo-1580781601169-04f5d8c6c6d7?w=300', 'Salary: $100,000/year\nPerks: Health benefits, stock options\nTools: SQL, Oracle, MongoDB'),
(73, 'IT Support Specialist', 'TechHelp', 'Provide technical support and troubleshoot hardware/software issues.', 'Austin, TX', 'IT', 9, '2025-06-28 11:40:00', 'https://images.unsplash.com/photo-1570224302819-25856412b370?w=300', 'Salary: $50,000/year\nPerks: Flexible hours, paid time off\nTools: Windows OS, Help Desk software'),
(74, 'E-commerce Manager', 'Shopify', 'Manage online store and marketing strategies for e-commerce business.', 'San Diego, CA', 'Marketing', 9, '2025-06-28 11:45:00', 'https://images.unsplash.com/photo-1516728778615-2d4bb47c2d58?w=300', 'Salary: $85,000/year\nPerks: Free lunches, career growth opportunities\nTools: Shopify, Google Analytics'),
(75, 'Content Writer', 'Creative Content', 'Write and edit content for blogs, websites, and marketing materials.', 'Los Angeles, CA', 'Writing', 9, '2025-06-28 11:50:00', 'https://images.unsplash.com/photo-1593507319477-c59b5c7b1e43?w=300', 'Salary: $55,000/year\nPerks: Remote work, paid vacations\nTools: Google Docs, Grammarly'),
(76, 'SEO Manager', 'SEOPro', 'Oversee and implement SEO strategies for client websites.', 'New York, NY', 'Marketing', 9, '2025-06-28 11:55:00', 'https://images.unsplash.com/photo-1564063279-76ca4c0620f3?w=300', 'Salary: $75,000/year\nPerks: Health benefits, flexible work schedule\nTools: Ahrefs, Google Search Console');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('employer','job_seeker','admin') NOT NULL DEFAULT 'job_seeker',
  `full_name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `user_type`, `full_name`, `phone`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$abcdefg...', 'admin', 'Admin User', '555-0000', '2025-05-25 12:18:10'),
(2, 'employer1', 'employer1@example.com', '$2y$10$examplehash1', 'employer', 'Employer One', '555-1111', '2025-05-25 12:18:11'),
(3, 'jobseeker1', 'jobseeker1@example.com', '$2y$10$examplehash2', 'job_seeker', 'Job Seeker One', '555-2222', '2025-05-25 12:18:12'),
(4, 'employer2', 'employer2@example.com', '$2y$10$examplehash3', 'employer', 'Employer Two', '555-3333', '2025-05-25 12:18:13'),
(5, 'jobseeker2', 'jobseeker2@example.com', '$2y$10$examplehash4', 'job_seeker', 'Job Seeker Two', '555-4444', '2025-05-25 12:18:14'),
(6, 'employer3', 'employer3@example.com', '$2y$10$examplehash5', 'employer', 'Employer Three', '555-5555', '2025-05-25 12:18:15'),
(7, 'jobseeker3', 'jobseeker3@example.com', '$2y$10$examplehash6', 'job_seeker', 'Job Seeker Three', '555-6666', '2025-05-25 12:18:16'),
(8, 'adminuser', 'adminuser@example.com', '$2y$10$examplehash7', 'admin', 'Administrator', '555-7777', '2025-05-25 12:18:17'),
(9, 'donart', 'donart@gmail.com', '$2y$10$pn88ydDQLx.ScQRCmCPiS.15v7wpoQfYKYnUKRpAglQF1jkWwBuQu', 'employer', 'Donart Sefa', '3233311', '2025-06-28 09:32:18'),
(10, 'diar', 'diar@gmail.com', '$2y$10$4hvjFuN9vjtcnSdQC.v6TuwG/Ss8G6hd6nlKzt8A8rqeMqFAHPZYO', 'job_seeker', NULL, NULL, '2025-06-28 09:33:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posted_by` (`posted_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`posted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
