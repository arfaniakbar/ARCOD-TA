-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 14, 2025 at 01:35 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_magang`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evidences`
--

CREATE TABLE `evidences` (
  `id` bigint UNSIGNED NOT NULL,
  `project_id` int DEFAULT NULL,
  `po_id` bigint DEFAULT NULL,
  `pangwas_id` bigint DEFAULT NULL,
  `tematik_id` bigint DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `file_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `catatan_admin` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `evidences`
--

INSERT INTO `evidences` (`id`, `project_id`, `po_id`, `pangwas_id`, `tematik_id`, `user_id`, `lokasi`, `deskripsi`, `file_path`, `status`, `catatan_admin`, `created_at`, `updated_at`) VALUES
(33, 4, NULL, NULL, NULL, 3, 'Banjarmasin', NULL, '[{\"path\":\"evidences\\/4\\/jAXwbNQR8sHlCjwCqV0s5RKzRCk04mnaUxr8xdxQ.jpg\",\"caption\":\"PU-AS-SC(1)\"},{\"path\":\"evidences\\/4\\/PaavGGK5rPCddpT0IR1tgjIsDKbyQfNnvuN0Ae80.jpg\",\"caption\":\"PU-AS-SC(10)\"},{\"path\":\"evidences\\/4\\/DrLKobpYzNlVaAo3CUls7zIrfno9YCq3rXGkbOM1.jpg\",\"caption\":\"PU-AS-SC(11)\"},{\"path\":\"evidences\\/4\\/RhHiyGIZcy4qdggeHQSlhZlI8qV8niAk9gQCQxOh.jpg\",\"caption\":\"PU-AS-SC(12)\"},{\"path\":\"evidences\\/4\\/OiuWKoqtEqNjTeW21YhfTqPzF04E6YY5cL00aQfw.jpg\",\"caption\":\"PU-AS-SC(13)\"},{\"path\":\"evidences\\/4\\/iISYPU0zCgbpnhTFKUyz9dA4uts6WdKCK7m3LcPq.jpg\",\"caption\":\"PU-AS-SC(14)\"},{\"path\":\"evidences\\/4\\/uiSEUwRRku9l3Z4lE3FWc861UOYoLlq1HM0zMnfl.jpg\",\"caption\":\"PU-AS-SC(15)\"},{\"path\":\"evidences\\/4\\/hm5aHNsxQWJjcq3gTSEPwQQ49Ut67wdRwDz4pFWd.jpg\",\"caption\":\"PU-AS-SC(16)\"},{\"path\":\"evidences\\/4\\/7HL5mwev82Z0UlrYL3hj9izHwBNBm4HdSnJOBenA.jpg\",\"caption\":\"PU-AS-SC(17)\"},{\"path\":\"evidences\\/4\\/MeOoHQ9xzPRadcQV7trkkVF9gp4HJVFyNK8ZgLDV.jpg\",\"caption\":\"PU-AS-SC(18)\"}]', 'approved', NULL, '2025-11-03 18:25:23', '2025-11-03 18:26:10'),
(34, 5, NULL, NULL, NULL, 3, 'Banjarmasin Timur', NULL, '[{\"path\":\"evidences\\/5\\/uS4zFyakZSuCW8uBjUQ7fxw63pCx4PUHXhcoYgKw.png\",\"caption\":\"photo_2025-10-23_13-38-10-removebg-preview\"},{\"path\":\"evidences\\/5\\/ELpmRmh0as2EILsYvSmG4qzGfgWbqEYUTEVz5iWQ.jpg\",\"caption\":\"Spur Digitization Through Fiber Optic, Telkom Inaugurates Sumsel Modern Broadband Province\"},{\"path\":\"evidences\\/5\\/Frx4U2bDkTvfDxLnUO78qv109jzksAT9lb9y565g.jpg\",\"caption\":\"Telkomsel berkomitmen tingkatkan pemerataan sinyal 4G\"},{\"path\":\"evidences\\/5\\/qmoAa6sbcVPs7g9mL25K4CyNBuoy8EvaJKDq0gk9.jpg\",\"caption\":\"photo_2025-10-15_10-06-31\"},{\"path\":\"evidences\\/5\\/4TKv6BhAdJOusf9YZXhpposf84HHdhMCKT2ZbmqR.jpg\",\"caption\":\"photo_2025-10-15_14-08-39 - Copy\"},{\"path\":\"evidences\\/5\\/2XY88M4ArQ5XTAljuFLHzQZUadutN2fwNVOmZqhi.jpg\",\"caption\":\"photo_2025-10-15_14-08-39\"}]', 'approved', NULL, '2025-11-04 21:32:17', '2025-11-04 23:03:22'),
(35, 6, NULL, NULL, NULL, 3, 'Banjarmasin Tengah', 'a', '[{\"path\":\"evidences\\/6\\/o29EIn0gttdpEF0hDfB0pGThoDx0xnqfaqW3i66U.jpg\",\"caption\":\"photo_2025-10-15_14-08-25\"},{\"path\":\"evidences\\/6\\/nSmVkHTvyB8R3opJoo2OwI3z0DxY1Lmu1r91TM2L.jpg\",\"caption\":\"photo_2025-10-15_14-08-20\"},{\"path\":\"evidences\\/6\\/UjRxfirppiThUKBfAAyMZLXspUU7K6oOkA6Kc6Uc.jpg\",\"caption\":\"photo_2025-08-28_10-18-35\"},{\"path\":\"evidences\\/6\\/DuEJRNu4VPUZcF2zywK7FV3ZoZrVxm9esz7MSAAa.jpg\",\"caption\":\"photo_2025-08-28_10-18-31 (2)\"},{\"path\":\"evidences\\/6\\/geKc2Mp7HfwHL1swSAZUefbRJBp7f7Q3Ih6KGAaS.jpg\",\"caption\":\"photo_2025-08-28_10-18-31\"},{\"path\":\"evidences\\/6\\/krPWmjDcwwV609RZ4V41pJHIUaWtD53wH4692NC3.jpg\",\"caption\":\"photo_2025-10-01_14-48-24\"}]', 'approved', NULL, '2025-11-04 23:21:21', '2025-11-06 17:06:34'),
(36, 7, 2, 10, 1, 3, 'Banjarmasin Timur Pekapuran Raya', NULL, '[{\"path\":\"evidences\\/7\\/sfnqReLWq58igZeLVdJD0KKWidyiLA2sa2sEyWfm.jpg\",\"caption\":\"photo_2025-10-15_10-06-31\"},{\"path\":\"evidences\\/7\\/75jlc4ggQAoZnt4y4teYQZa70bw1vBb3ClaCbaKl.jpg\",\"caption\":\"photo_2025-10-15_14-08-39 - Copy\"},{\"path\":\"evidences\\/7\\/f5mh3rHySgcI4wNrbqYsuAgo49ikbETva9aDtYE2.jpg\",\"caption\":\"photo_2025-10-15_14-08-39\"},{\"path\":\"evidences\\/7\\/Ynar2E4vWeC7HPSlAk9W9XOcNJBoKAc23AnYEKsY.jpg\",\"caption\":\"photo_2025-10-15_14-08-35\"},{\"path\":\"evidences\\/7\\/Ug5ksJnrrAD0Y7Fxe8ZbggAjM7ZpoVgeVI2wWvNf.jpg\",\"caption\":\"photo_2025-10-15_14-08-30\"},{\"path\":\"evidences\\/7\\/lET2nmlJC5g0abcAWqQmeE8cSzHi83UeQlkD0q2j.jpg\",\"caption\":\"photo_2025-10-15_14-08-25\"}]', 'approved', NULL, '2025-11-09 17:17:15', '2025-11-09 17:17:59'),
(37, 8, 5, 11, 1, 3, 'Banjarmasin Kelayan', NULL, '[{\"path\":\"evidences\\/8\\/29pXwFrRxesPKUCax5jmzMbnz7lnfjBXCzgaSaYj.jpg\",\"caption\":\"ODP(ODP-1)\"},{\"path\":\"evidences\\/8\\/Q6mS80GycBVg68o84SLMVzTFMFFEP8vzB2COmxQK.jpg\",\"caption\":\"ODP(ODP-2)\"},{\"path\":\"evidences\\/8\\/hJCqJyX7DxCBRl8qZ7DXjV5zVnhi70iitelP8VEu.jpg\",\"caption\":\"ODP(ODP-3)\"},{\"path\":\"evidences\\/8\\/RvwIJvGLthNjCMaIQNgu2sKyw9xdsqe3BQ8tbNPx.jpg\",\"caption\":\"ODP(ODP-4)\"},{\"path\":\"evidences\\/8\\/1cFOUcd5OoSVCiv8pwBonIHKLqIjkcVCXkU3kWzd.jpg\",\"caption\":\"ODP(ODP-5)\"},{\"path\":\"evidences\\/8\\/DG1ykHxy83iE45IXcAb4MujRDqkQwMNqeyJZEi94.jpg\",\"caption\":\"ODP(ODP-6)\"}]', 'approved', NULL, '2025-11-09 17:36:25', '2025-11-09 17:37:14'),
(38, 9, 4, 15, 1, 3, 'Banjarmasin Kelayan Utara', NULL, '[{\"path\":\"evidences\\/9\\/7osPTHo7vVL5tDlRGSuIVHW1bqbEx76j46Mh3aTT.jpg\",\"caption\":\"EV(0)\"},{\"path\":\"evidences\\/9\\/dksARqQ9sTgYR3bOIKxnzo3xBHf34dZufsCcgHZz.jpg\",\"caption\":\"EV(1)\"},{\"path\":\"evidences\\/9\\/nBPHIlwsSQpNXZLtmgsQ9xtMBeqFSIIfZoUMdDhh.jpg\",\"caption\":\"EV(2)\"},{\"path\":\"evidences\\/9\\/NStbXr3ss8DuHIum8HJVvgV2UK8wOkU3x7SeDbPd.jpg\",\"caption\":\"EV(3)\"},{\"path\":\"evidences\\/9\\/z2LQCpDlMCwUCTynLKAEkUB1bVhBMUhX9943eIY7.jpg\",\"caption\":\"EV(4)\"},{\"path\":\"evidences\\/9\\/cdrDo28K0S9Di6UODwBp0RZFmMaTLwa1ZEgclqPe.jpg\",\"caption\":\"EV(5)\"},{\"path\":\"evidences\\/9\\/1ZUx1EjdcmIGQAb9fGW3beIGFrMikRfy8rUaT736.jpg\",\"caption\":\"EV(6)\"},{\"path\":\"evidences\\/9\\/SHmfNEMNNcOT7RfjjkzOgg9H8X8Lr7nLyNICV6NQ.jpg\",\"caption\":\"EV(7)\"},{\"path\":\"evidences\\/9\\/XINfJx6sw8LURPmsAFMVbttptYWe1g692Xg0gYk2.jpg\",\"caption\":\"EV(IN)\"},{\"path\":\"evidences\\/9\\/V7qZ9th3aY2lmGNzuoz2Lmt55xv90C756sWgmeZx.jpg\",\"caption\":\"EV(1)\"},{\"path\":\"evidences\\/9\\/VLyJ73A7qaPG9Ldz7nM2YV9OAvhOnmHCppNrTi5H.jpg\",\"caption\":\"EV(10-11)\"},{\"path\":\"evidences\\/9\\/cmxqE4G3fMGLb9OTmA3dmPUVKg0911SQ30XX8Dqc.jpg\",\"caption\":\"EV(12-13)\"},{\"path\":\"evidences\\/9\\/ASEV4LhoItkvKKzfMx983JrrWtRKKYMw2uvaCQVv.jpg\",\"caption\":\"EV(14-15)\"},{\"path\":\"evidences\\/9\\/duiM8Wk2cYuWxxxY8f7waWLzQ5TP4zDjco9Dgt2x.jpg\",\"caption\":\"EV(16-17)\"},{\"path\":\"evidences\\/9\\/ufbT3vdkH2cb3cBaBHQ6bpqNB5RyhhT31t7ZHjjY.jpg\",\"caption\":\"EV(18-19)\"},{\"path\":\"evidences\\/9\\/mxzQEWRcLSpay2wPjd7mHR2fp0G9U1ylrP9iI1oK.jpg\",\"caption\":\"EV(2-3)\"},{\"path\":\"evidences\\/9\\/dyaTEQbqfIKrks0kTrO2YKe2UHVsfJSFcuyZcEuw.jpg\",\"caption\":\"EV(20-21)\"},{\"path\":\"evidences\\/9\\/V5j9hWnU9dT5TJK6g5zClqpzKuSC5WphhyNfdTCC.jpg\",\"caption\":\"EV(22-23-24)\"},{\"path\":\"evidences\\/9\\/WffH8jLVEcBnt9xd9gSViWiYX9rWryafStHXpZ6R.jpg\",\"caption\":\"EV(25)\"},{\"path\":\"evidences\\/9\\/kura0xxL6fFJ6By1YkXfnp9tAfglGVgz6XjfThFB.jpg\",\"caption\":\"EV(4-5)\"}]', 'approved', NULL, '2025-11-11 18:27:17', '2025-11-11 18:36:00'),
(39, 10, 3, 10, 1, 3, 'Banjarbaru Landasan Ulin', NULL, '[{\"path\":\"evidences\\/10\\/6jDOyhYaZbtjhkyah7jfK673ga6kp1LkjHMsP7ed.jpg\",\"caption\":\"EV(0)\"},{\"path\":\"evidences\\/10\\/0VEPkVMe78wdzKs0xpyIyZWazvUaBMVNkygOZTyp.jpg\",\"caption\":\"EV(1)\"},{\"path\":\"evidences\\/10\\/6LJGqgWy4XvkcQxqJyBA6G0E1XEV7kohYXxZKheX.jpg\",\"caption\":\"EV(2)\"},{\"path\":\"evidences\\/10\\/euGg7e3eQSgosikQnM1wFVZnmPGxozWiDLcVn0oD.jpg\",\"caption\":\"EV(3)\"},{\"path\":\"evidences\\/10\\/BlesJcIBPVeM9KOWTMjP4G4suqJScGeHCKEbz2vR.jpg\",\"caption\":\"EV(4)\"},{\"path\":\"evidences\\/10\\/rOMzbvULs93GWa0rpGGmDp0irD702M2onyy8KTQF.jpg\",\"caption\":\"EV(5)\"},{\"path\":\"evidences\\/10\\/krTxpb8Tcm1WcqCrvl1GLGKt5OYADvYmZw2AKYvj.jpg\",\"caption\":\"EV(6)\"},{\"path\":\"evidences\\/10\\/Q8hGaFlJcAUxo1lzIm64RUZwodZXiU8f9VSONQAX.jpg\",\"caption\":\"EV(7)\"},{\"path\":\"evidences\\/10\\/Ej7wfHP7QXHUqdCqy3oEU4Qyg5neVYSZMkmyN39R.jpg\",\"caption\":\"EV(IN)\"},{\"path\":\"evidences\\/10\\/ftmux2Y5gZU0bYnygLka0J7ZkFz0BtEqBTFgmgqS.jpg\",\"caption\":\"EV(1)\"},{\"path\":\"evidences\\/10\\/hp48itOCJY1wserVA3GMZq9WvdONQFiqwwFfvjFI.jpg\",\"caption\":\"EV(10-11)\"},{\"path\":\"evidences\\/10\\/qibKWDW0C8grGbjWN45u93hIHC8zpvvQcXVk8hno.jpg\",\"caption\":\"EV(12-13)\"},{\"path\":\"evidences\\/10\\/ZyooDeQECCE4YH6yTYKGr4GGZg0MTACYXSkKK7BR.jpg\",\"caption\":\"EV(14-15)\"},{\"path\":\"evidences\\/10\\/vL0NsQMjPc7zeVIK1X84Aovg53xmLzkZeeI0ihWT.jpg\",\"caption\":\"EV(16-17)\"},{\"path\":\"evidences\\/10\\/ff0QUR3GoOJgxgTeHbArNx0MEnAfLB6SjM7DaMjb.jpg\",\"caption\":\"EV(18-19)\"},{\"path\":\"evidences\\/10\\/3tMFMTDtCyuc8mUC1UrY9dQZZplKR4zAGtM83qRJ.jpg\",\"caption\":\"EV(2-3)\"},{\"path\":\"evidences\\/10\\/yowitD7XInCKuwDbvrqeO15uZMnecd3pbXeGuNU9.jpg\",\"caption\":\"EV(20-21)\"},{\"path\":\"evidences\\/10\\/fbK2QhFBFwipH7hbFiCQGbtwqSkA5Uh0X8x1AfWq.jpg\",\"caption\":\"EV(22-23-24)\"},{\"path\":\"evidences\\/10\\/FZMgJUom1GFmWJfc8Bi7yCHUKnGOoLnzq7SY5wxP.jpg\",\"caption\":\"EV(25)\"},{\"path\":\"evidences\\/10\\/EytYhyI6dSmQIxdlm6S999xdNTXRqMOMWwyw0Y40.jpg\",\"caption\":\"EV(4-5)\"}]', 'approved', NULL, '2025-11-11 23:21:00', '2025-11-11 23:22:12'),
(40, 11, 6, 17, 1, 5, 'Sungai Lulut', NULL, '[{\"path\":\"evidences\\/11\\/nMWZ9nscMDdrzpgLwsQQ4XpdiIXkM38BglyjF4s2.jpg\",\"caption\":\"ODP(ODP-1)\"},{\"path\":\"evidences\\/11\\/x98dHVxBvV2bd6WlsjS2xHbnPtU1ikrdlTMTj2ED.jpg\",\"caption\":\"ODP(ODP-2)\"},{\"path\":\"evidences\\/11\\/LdebQYr05pbxzQH0OGQgDk3U54ctZEN9Whdkacuz.jpg\",\"caption\":\"ODP(ODP-3)\"},{\"path\":\"evidences\\/11\\/uo734vwg3GgLfW8eNE2CV7KBH0L94OYnSbUGK96Q.jpg\",\"caption\":\"ODP(ODP-4)\"},{\"path\":\"evidences\\/11\\/6Gi5TAzUJ6WDoOaJlznfxoVrP0bL4jJtVrWntv6B.jpg\",\"caption\":\"ODP(ODP-5)\"},{\"path\":\"evidences\\/11\\/KxlFnzd60ABKxuxGoLbsk9EcYLVLM5b76lia0kya.jpg\",\"caption\":\"ODP(ODP-6)\"}]', 'approved', NULL, '2025-11-11 23:26:28', '2025-11-11 23:26:58'),
(41, 12, 7, 12, 1, 3, 'Banjarmasin', NULL, '[{\"path\":\"evidences\\/12\\/NkGD7KUvqrHJng42JwoN0TwhTXysJOUtXrhRX6Oh.jpg\",\"caption\":\"EV(0)\"},{\"path\":\"evidences\\/12\\/lzcE61I2fpsspcogdlfCzJsPEJACEkl5BR6un4j1.jpg\",\"caption\":\"EV(1)\"},{\"path\":\"evidences\\/12\\/SALVdbuLi1RFx6RNsCq25J2ZL8ylupjShF4OYwuN.jpg\",\"caption\":\"EV(2)\"},{\"path\":\"evidences\\/12\\/vKiGRJHi87nOzzQCKOfT2JVPLHCq3McQgz3YCXcK.jpg\",\"caption\":\"EV(3)\"},{\"path\":\"evidences\\/12\\/oHhnluCAXoO7Px6Azvzp811s11dGdm6wy607AbNH.jpg\",\"caption\":\"EV(4)\"},{\"path\":\"evidences\\/12\\/jPX6KUQgSuMWHVXVM8lMd4aagimZbWSNKpMi37g1.jpg\",\"caption\":\"EV(5)\"},{\"path\":\"evidences\\/12\\/6sN7Za46Zq7TYhiMamnBpDxJKiDRrs7OAE9GvNI5.jpg\",\"caption\":\"EV(6)\"},{\"path\":\"evidences\\/12\\/jO6ZaxRCUQ26codhNAr9MjjmEan38k5O8tFriJQh.jpg\",\"caption\":\"EV(7)\"},{\"path\":\"evidences\\/12\\/7CRPpWn7uYzDSSrM25KF29nXnwtdlNMOFU1dzZkR.jpg\",\"caption\":\"EV(IN)\"},{\"path\":\"evidences\\/12\\/cvtrd7To1kbBWMwFUXqJBhdWP1Lw27XIV9lOWkYG.jpg\",\"caption\":\"EV(1)\"},{\"path\":\"evidences\\/12\\/2osiezFNmWFgC02kyNBCYFKM6bITZToxFZA139uD.jpg\",\"caption\":\"EV(10-11)\"},{\"path\":\"evidences\\/12\\/slMpzT6KlDhlD2SXiXTcLahXHfB69pGMNtlF86gj.jpg\",\"caption\":\"EV(12-13)\"},{\"path\":\"evidences\\/12\\/WxoX5YKiCIMy9TFGUbVOx5UxnSaAv26o255a7LXK.jpg\",\"caption\":\"EV(14-15)\"},{\"path\":\"evidences\\/12\\/NKkGeUnagcpo71Lo5RAHta7havQiUjjuCk1CW9u1.jpg\",\"caption\":\"EV(16-17)\"},{\"path\":\"evidences\\/12\\/whjGc9wUZKWIvjXl5lNNEHvTUWET25mVzEHXQnfs.jpg\",\"caption\":\"EV(18-19)\"},{\"path\":\"evidences\\/12\\/C8cJWf2nZAlD6Rfgs1WlMJLjygavGDNpeNFXnbXh.jpg\",\"caption\":\"EV(2-3)\"},{\"path\":\"evidences\\/12\\/2awWtopzJbPgrI3iSq3FVWX2wXW7pg36gMHZELne.jpg\",\"caption\":\"EV(20-21)\"},{\"path\":\"evidences\\/12\\/XI5XV5RNJ92MkSCRWG2aWEFO3IXiAvaJnUPEDE5h.jpg\",\"caption\":\"EV(22-23-24)\"},{\"path\":\"evidences\\/12\\/E6R609bTjdB7EWiCLefPr85ZSf11YtKWplj2eX0b.jpg\",\"caption\":\"EV(25)\"},{\"path\":\"evidences\\/12\\/eUujLLtoltI7tTuLrxwdeIOD5d6yFZzFFcRUbT2g.jpg\",\"caption\":\"EV(4-5)\"}]', 'pending', NULL, '2025-11-11 23:41:53', '2025-11-11 23:41:53');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_25_015448_create_evidence_table', 1),
(5, '2025_09_25_053205_add_status_to_evidences_table', 1),
(6, '2025_10_10_023002_rename_judul_to_lokasi_in_evidences_table', 1),
(7, '2025_10_14_055929_ubah_kolom_file_path_pada_tabel_evidences', 2),
(8, '2025_10_23_005048_alter_file_path_column_on_evidences_table', 3),
(9, '2025_10_26_110654_create_sessions_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `pangwas`
--

CREATE TABLE `pangwas` (
  `id` bigint NOT NULL,
  `nama_pangwas` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pangwas`
--

INSERT INTO `pangwas` (`id`, `nama_pangwas`, `created_at`, `updated_at`) VALUES
(10, 'Cole Palmer', '2025-11-04 23:24:44', '2025-11-04 23:24:44'),
(11, 'Estêvão Willian', '2025-11-04 23:25:07', '2025-11-04 23:25:07'),
(12, 'Alejandro Garnacho', '2025-11-04 23:25:18', '2025-11-04 23:25:18'),
(13, 'João Pedro', '2025-11-04 23:25:38', '2025-11-04 23:25:38'),
(14, 'Liam Delap', '2025-11-04 23:25:47', '2025-11-04 23:25:47'),
(15, 'Jorrel Hato', '2025-11-04 23:25:58', '2025-11-04 23:25:58'),
(16, 'Facundo Buonanotte', '2025-11-04 23:26:20', '2025-11-04 23:26:20'),
(17, 'Enzo Fernández', '2025-11-04 23:26:28', '2025-11-04 23:26:28'),
(18, 'Jamie Gittens', '2025-11-04 23:26:43', '2025-11-04 23:26:43'),
(19, 'Moisés Caicedo', '2025-11-04 23:27:04', '2025-11-04 23:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int NOT NULL,
  `lokasi` text NOT NULL,
  `deskripsi` text,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `lokasi`, `deskripsi`, `ts`) VALUES
(1, 'test', 'asd', '2025-10-22 06:29:42'),
(2, 'test2', 'asd', '2025-10-22 06:31:19'),
(3, 'Banjarmasin', NULL, '2025-10-28 00:12:54'),
(4, 'Banjarmasin', NULL, '2025-11-04 02:25:22'),
(5, 'Banjarmasin Timur', NULL, '2025-11-05 05:32:17'),
(6, 'Banjarmasin Tengah', 'a', '2025-11-05 07:21:21'),
(7, 'Banjarmasin Timur Pekapuran Raya', NULL, '2025-11-10 01:17:13'),
(8, 'Banjarmasin Kelayan', NULL, '2025-11-10 01:36:25'),
(9, 'Banjarmasin Kelayan Utara', NULL, '2025-11-12 02:27:16'),
(10, 'Banjarbaru Landasan Ulin', NULL, '2025-11-12 07:20:59'),
(11, 'Sungai Lulut', NULL, '2025-11-12 07:26:28'),
(12, 'Banjarmasin', NULL, '2025-11-12 07:41:53');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `id` bigint NOT NULL,
  `no_po` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`id`, `no_po`, `created_at`, `updated_at`) VALUES
(2, 'INC41928890', '2025-11-09 16:49:58', '2025-11-09 16:49:58'),
(3, 'INC41928745', '2025-11-09 17:28:48', '2025-11-09 17:28:48'),
(4, 'INC41927465', '2025-11-09 17:29:09', '2025-11-09 17:29:09'),
(5, 'INC41920890', '2025-11-09 17:29:19', '2025-11-09 17:29:19'),
(6, 'INC41990877', '2025-11-11 23:25:53', '2025-11-11 23:25:53'),
(7, 'INC41929975', '2025-11-11 23:40:35', '2025-11-11 23:40:35');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2LUniLW9tlve7R0s02weveT40h0uB6muWWrMt6Nb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUEhoamhZY0F5b05NcFBVZ1RXQnIzQnQwTG5iYUI3WmxlNFZ4U3FudSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2xhcG9yYW4iO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1762925738),
('jiEV65XveorB1kev9QWd1BQm8mv8PZNU12qte89e', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTFh3QWtKeldncFFWeWhVNVBMMURxNXo4dzBLSGloNHNucm5DdVJKdiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=', 1762932548),
('ytqBmpzZUy5kJ1FMFke83vgtO4lOrtDdZ0pDSARE', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicjBOTGxkM3NIeVR1NE1oamV0dHc3aDB5cFJlU3Zkb0l4THFOVDlYayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=', 1762936231);

-- --------------------------------------------------------

--
-- Table structure for table `tematik`
--

CREATE TABLE `tematik` (
  `id` bigint NOT NULL,
  `nama_tematik` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tematik`
--

INSERT INTO `tematik` (`id`, `nama_tematik`, `created_at`, `updated_at`) VALUES
(1, 'Muhammad Riza', '2025-11-09 17:15:48', '2025-11-09 17:15:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'karyawan',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Telkom', 'admin', 'admin@telkom.co.id', NULL, '$2y$12$IxZpWPWS6OnIyVNq4oTQheUQnw58OFBm8LCi44Xzv3V5JBo0nfC3q', 'admin', NULL, '2025-10-09 18:32:43', '2025-10-09 18:32:43'),
(2, 'Budi Karyawan', 'budi', 'budi@telkom.co.id', NULL, '$2y$12$8frjFPX8iZbD2FBwWmBdIuZ63KTFBBOYupkSeSw7ctsEXyXN6BvNi', 'karyawan', NULL, '2025-10-09 18:32:44', '2025-10-09 18:32:44'),
(3, 'Muhammad Riza', 'riza', 'muhammadrizaaa594@gmail.com', NULL, '$2y$12$IRnPuhrdur94FbghckclWuSccBRKlwml0AKMULcmHXNmP6abcZdXC', 'karyawan', NULL, '2025-10-09 18:40:23', '2025-10-09 18:40:23'),
(4, 'Lionel Messi', 'goat', 'messi@telkom.com', NULL, '$2y$12$GeYg8LwjHu8vmOFqdk6om.T/t2k5.mUnRpX2jqbAMSwIqlkvHFs9O', 'karyawan', NULL, '2025-10-21 18:54:48', '2025-10-21 18:54:48'),
(5, 'Ahmad Fikriannor', 'Fikri', 'ahmadfikriannor@gmail.com', NULL, '$2y$12$TI7hgBWZJ4ylrqyk0PWQEOlPhIE9EL2grgn2gM1fDdvm68n6l/.yW', 'karyawan', NULL, '2025-11-11 23:24:53', '2025-11-11 23:24:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `evidences`
--
ALTER TABLE `evidences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evidences_user_id_foreign` (`user_id`),
  ADD KEY `fk_evidence_po` (`po_id`),
  ADD KEY `fk_evidence_tematik` (`tematik_id`),
  ADD KEY `fk_evidences_pangwas` (`pangwas_id`),
  ADD KEY `fk_evidences_project` (`project_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pangwas`
--
ALTER TABLE `pangwas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_po` (`no_po`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tematik`
--
ALTER TABLE `tematik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `evidences`
--
ALTER TABLE `evidences`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pangwas`
--
ALTER TABLE `pangwas`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tematik`
--
ALTER TABLE `tematik`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `evidences`
--
ALTER TABLE `evidences`
  ADD CONSTRAINT `evidences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_evidence_pangwas` FOREIGN KEY (`pangwas_id`) REFERENCES `pangwas` (`id`),
  ADD CONSTRAINT `fk_evidence_po` FOREIGN KEY (`po_id`) REFERENCES `purchase_order` (`id`),
  ADD CONSTRAINT `fk_evidence_tematik` FOREIGN KEY (`tematik_id`) REFERENCES `tematik` (`id`),
  ADD CONSTRAINT `fk_evidence_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_evidences_pangwas` FOREIGN KEY (`pangwas_id`) REFERENCES `pangwas` (`id`),
  ADD CONSTRAINT `fk_evidences_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
