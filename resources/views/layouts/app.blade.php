<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'RecipeNest') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }

        /* Navigation */
        .navbar {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-menu {
            display: flex;
            gap: 0.5rem;
            list-style: none;
            align-items: center;
            flex-wrap: wrap;
        }

        .navbar-menu a {
            color: white;
            text-decoration: none;
            padding: 0.6rem 1rem;
            border-radius: 6px;
            transition: all 0.3s;
            font-weight: 500;
        }

        .navbar-menu a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .navbar-menu .active {
            background-color: #e74c3c;
            box-shadow: 0 2px 4px rgba(231, 76, 60, 0.3);
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Enhanced Alerts */
        .alert {
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 12px;
            border-left: 4px solid;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
        }

        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0.05;
            pointer-events: none;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-color: #28a745;
            color: #155724;
        }

        .alert-success::before {
            background: #28a745;
        }

        .alert-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-color: #dc3545;
            color: #721c24;
        }

        .alert-error::before {
            background: #dc3545;
        }

        .alert-info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            border-color: #17a2b8;
            color: #0c5460;
        }

        .alert-info::before {
            background: #17a2b8;
        }

        .alert::after {
            content: attr(data-icon);
            font-size: 1.25rem;
            opacity: 0.7;
        }

        /* Enhanced Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            letter-spacing: 0.025em;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }

        .btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }

        .btn-success {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
            color: white;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #229954 0%, #1d8447 100%);
        }

        .btn-danger {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
            color: white;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #7f8c8d 0%, #707b7c 100%);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #e67e22 0%, #d35400 100%);
        }

        /* Enhanced Cards */
        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.07), 0 1px 3px rgba(0,0,0,0.06);
            padding: 2rem;
            margin-bottom: 2rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card:hover::before {
            opacity: 1;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15), 0 4px 8px rgba(0,0,0,0.1);
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f8f9fa;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-header::before {
            content: '';
            width: 4px;
            height: 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
        }

        /* Enhanced Forms */
        .form-group {
            margin-bottom: 1.75rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.95rem;
            letter-spacing: 0.025em;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e1e8ed;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #f8f9fa;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), 0 2px 8px rgba(0,0,0,0.08);
            transform: translateY(-1px);
        }

        .form-control::placeholder {
            color: #a0aec0;
            font-style: italic;
        }

        textarea.form-control {
            min-height: 140px;
            resize: vertical;
        }

        .form-error {
            color: #e74c3c;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.5rem;
            background: rgba(231, 76, 60, 0.05);
            border-radius: 6px;
            border-left: 3px solid #e74c3c;
        }

        .form-error::before {
            content: '⚠️';
            font-size: 0.875rem;
        }

        /* Grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        /* Recipe Card */
        .recipe-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.07);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .recipe-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
        }

        .recipe-card-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .recipe-card-body {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .recipe-card-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: #2c3e50;
            line-height: 1.4;
        }

        .recipe-card-category {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.35rem 0.85rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .recipe-card-description {
            color: #7f8c8d;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            flex: 1;
        }

        .recipe-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #ecf0f1;
            margin-top: auto;
        }

        /* Enhanced Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            font-weight: 700;
            border-radius: 20px;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .badge:hover::before {
            left: 100%;
        }

        .badge-pending {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        }

        .badge-approved {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        }

        .badge-rejected {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }

        .badge-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Enhanced Table */
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.07);
        }

        .table th,
        .table td {
            padding: 1.25rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid #f1f3f4;
            font-weight: 500;
        }

        .table th {
            background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
            color: white;
            font-weight: 700;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #f1f3f4 100%);
            transform: scale(1.01);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Enhanced Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 3rem;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span {
            padding: 0.75rem 1rem;
            border: 2px solid #e1e8ed;
            border-radius: 8px;
            text-decoration: none;
            color: #495057;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-width: 44px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .pagination a:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
        }

        .pagination .active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
        }

        /* Enhanced Stars Rating */
        .stars {
            display: inline-flex;
            gap: 0.125rem;
        }

        .star {
            color: #e1e8ed;
            font-size: 1.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .star:hover {
            transform: scale(1.1);
        }

        .star.filled {
            color: #f39c12;
            text-shadow: 0 0 8px rgba(243, 156, 18, 0.5);
            animation: starPulse 0.3s ease;
        }

        @keyframes starPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        /* Enhanced Search Form */
        .search-form {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.07);
        }

        .search-form input,
        .search-form select {
            padding: 0.875rem 1rem;
            border: 2px solid #e1e8ed;
            border-radius: 8px;
            font-size: 0.95rem;
            background: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: inherit;
        }

        .search-form input:focus,
        .search-form select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .search-form input {
            flex: 1;
            min-width: 250px;
        }

        .search-form select {
            min-width: 200px;
        }

        .footer {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 4rem 0 1.5rem;
            margin-top: 4rem;
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #667eea 100%);
            opacity: 0.9;
        }

        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.35fr 1fr 1fr 1.2fr;
            gap: 2.5rem;
            padding-bottom: 2.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.12);
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .footer-brand img {
            height: 36px;
            width: auto;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 6px 18px rgba(0,0,0,0.25);
        }

        .footer-brand-name {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: 0.02em;
        }

        .footer-text {
            color: rgba(255,255,255,0.78);
            line-height: 1.7;
            font-size: 0.95rem;
            margin: 0 0 1.25rem 0;
        }

        .footer-social {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .footer-social a {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: white;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            transition: all 0.2s ease;
        }

        .footer-social a:hover {
            transform: translateY(-2px);
            background: rgba(255,255,255,0.14);
            border-color: rgba(102, 126, 234, 0.55);
            box-shadow: 0 10px 20px rgba(0,0,0,0.25);
        }

        .footer-title {
            margin: 0 0 1rem 0;
            font-weight: 800;
            letter-spacing: 0.02em;
            font-size: 1.05rem;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 0.65rem;
        }

        .footer-links a {
            text-decoration: none;
            color: rgba(255,255,255,0.78);
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: white;
        }

        .footer-subscribe-text {
            color: rgba(255,255,255,0.78);
            line-height: 1.7;
            font-size: 0.95rem;
            margin: 0 0 1rem 0;
        }

        .footer-subscribe {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 0.75rem;
            align-items: center;
        }

        .footer-subscribe input {
            width: 100%;
            padding: 0.85rem 1rem;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.18);
            background: rgba(255,255,255,0.08);
            color: white;
            outline: none;
        }

        .footer-subscribe input::placeholder {
            color: rgba(255,255,255,0.55);
        }

        .footer-subscribe input:focus {
            border-color: rgba(102, 126, 234, 0.8);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.14);
        }

        .footer-subscribe button {
            padding: 0.85rem 1.1rem;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            box-shadow: 0 10px 20px rgba(0,0,0,0.22);
            transition: transform 0.2s ease;
            white-space: nowrap;
        }

        .footer-subscribe button:hover {
            transform: translateY(-2px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 1.5rem;
            color: rgba(255,255,255,0.62);
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* Enhanced Responsive Design */
        @media (max-width: 768px) {
            .navbar-container {
                flex-direction: column;
                gap: 1rem;
            }

            .navbar-menu {
                flex-direction: column;
                width: 100%;
                gap: 0.25rem;
            }

            .navbar-menu a {
                padding: 0.75rem 1rem;
                border-radius: 8px;
            }

            .container {
                padding: 1rem;
            }

            .card {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .card-header {
                font-size: 1.25rem;
            }

            .btn {
                padding: 0.625rem 1.25rem;
                font-size: 0.875rem;
            }

            .grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .table {
                font-size: 0.875rem;
            }

            .table th,
            .table td {
                padding: 0.75rem 1rem;
            }

            .search-form {
                padding: 1rem;
                gap: 0.75rem;
            }

            .search-form input,
            .search-form select {
                min-width: 100%;
            }

            .pagination {
                gap: 0.25rem;
            }

            .pagination a,
            .pagination span {
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
                min-width: 36px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .footer-subscribe {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0.75rem;
            }

            .card {
                padding: 1rem;
            }

            .card-header {
                font-size: 1.125rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .card-header::before {
                width: 100%;
                height: 3px;
            }

            .btn {
                width: 100%;
                padding: 0.75rem;
            }

            .form-control {
                padding: 0.75rem;
            }

            .alert {
                padding: 0.75rem 1rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }

        /* Loading States */
        .loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Tooltips */
        .tooltip {
            position: relative;
        }

        .tooltip::before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #2c3e50;
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            z-index: 1000;
        }

        .tooltip:hover::before {
            opacity: 1;
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Selection Styling */
        ::selection {
            background: rgba(102, 126, 234, 0.2);
            color: #2c3e50;
        }

        /* Focus Visible for Accessibility */
        *:focus-visible {
            outline: 2px solid #667eea;
            outline-offset: 2px;
        }

        /* Print Styles */
        @media print {
            .navbar,
            .footer,
            .btn,
            .pagination {
                display: none;
            }

            .card {
                box-shadow: none;
                border: 1px solid #ddd;
                break-inside: avoid;
            }

            body {
                font-size: 12pt;
                line-height: 1.4;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('home') }}" class="navbar-brand" style="display: flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                <img src="{{ asset('image/logologo.jpg') }}" alt="RecipeNest" style="height: 32px; width: auto; border-radius: 4px; object-fit: cover;">
                <span style="color: #ffffffff; font-weight: 600; font-size: 1.2rem;">RecipeNest</span>
            </a>
            
            <ul class="navbar-menu">
                <li><a href="{{ route('recipes.index') }}">Browse Recipes</a></li>
                
                @auth
                    @if(auth()->user()->isAdmin())
                        <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                    @else
                        <li><a href="{{ route('recipes.create') }}">Submit Recipe</a></li>
                        <li><a href="{{ route('recipes.my') }}">My Recipes</a></li>
                        <li><a href="{{ route('recipes.saved') }}">Saved Recipes</a></li>
                    @endif
                    
                    <li><a href="{{ route('profile.edit') }}">Profile</a></li>
                    
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem;">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container">
        <!-- Enhanced Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success" data-icon="✅">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error" data-icon="❌">
                {{ session('error') }}
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info" data-icon="ℹ️">
                {{ session('info') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <div>
                    <div class="footer-brand">
                        <img src="{{ asset('image/logologo.jpg') }}" alt="RecipeNest">
                        <div class="footer-brand-name">RecipeNest</div>
                    </div>
                    <p class="footer-text">Your home for discovering and sharing delicious recipes around the world.</p>
                    <div class="footer-social">
                        <a href="#" aria-label="Instagram">IG</a>
                        <a href="#" aria-label="Facebook">FB</a>
                        <a href="#" aria-label="Twitter">X</a>
                        <a href="#" aria-label="YouTube">YT</a>
                    </div>
                </div>

                <div>
                    <h3 class="footer-title">Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('recipes.index') }}">Browse Recipes</a></li>
                        @auth
                            <li><a href="{{ route('recipes.create') }}">Submit Recipe</a></li>
                            <li><a href="{{ route('recipes.my') }}">My Recipes</a></li>
                            <li><a href="{{ route('recipes.saved') }}">Saved Recipes</a></li>
                        @else
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Sign Up</a></li>
                        @endauth
                    </ul>
                </div>

                <div>
                    <h3 class="footer-title">Categories</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('recipes.index') }}">Desserts</a></li>
                        <li><a href="{{ route('recipes.index') }}">Main Courses</a></li>
                        <li><a href="{{ route('recipes.index') }}">Appetizers</a></li>
                        <li><a href="{{ route('recipes.index') }}">Soups</a></li>
                        <li><a href="{{ route('recipes.index') }}">Salads</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="footer-title">Stay Updated</h3>
                    <p class="footer-subscribe-text">Subscribe for new recipes and cooking tips.</p>
                    <form class="footer-subscribe" action="#" method="GET">
                        <input type="email" name="email" placeholder="Your email" autocomplete="email">
                        <button type="submit">Join</button>
                    </form>
                </div>
            </div>

            <div class="footer-bottom">&copy; {{ date('Y') }} RecipeNest. All rights reserved.</div>
        </div>
    </footer>
</body>
</html>