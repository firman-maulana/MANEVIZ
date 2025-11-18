<?php

use App\Models\Product;
?>
@extends('layouts.app3')

@section('content')
<link rel="stylesheet" href="path/to/search-history-styles.css">
<style>
    /* Reset dan Base Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .allproduk-container {
        background-color: #ffffff;
        color: #fff;
        min-height: 100vh;
        font-family: 'Arial', sans-serif;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Hero Section */
    .hero-section {
        padding: 80px 0;
        text-align: center;
    }

    .hero-title {
        font-size: 3.5rem;
        color: #000000;
        font-weight: bold;
        margin-bottom: 20px;
        line-height: 1.2;
        margin-top: 50px;
    }

    .hero-subtitle {
        font-size: 3rem;
        color: #000000;
        font-weight: bold;
        margin-bottom: 40px;
        line-height: 1.2;
    }

    .btn-primary {
        background-color: #000000;
        color: #ffffff;
        padding: 15px 40px;
        border: none;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #333333;
        transform: translateY(-2px);
    }

    /* Section Styles */
    .section {
        padding: 60px 0;
    }

    .section-title {
        font-size: 2rem;
        color: #000000;
        font-weight: bold;
        margin-bottom: 40px;
    }

    /* Best Seller Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        margin-bottom: 40px;
    }

    .product-card {
        background-color: transparent;
        border-radius: 20px;
        overflow: visible;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        position: relative;
        text-decoration: none;
        display: block;
    }

    .product-card:hover {
        transform: translateY(-5px);
        text-decoration: none;
    }

    /* Perbaikan untuk gambar agar tidak terpotong di mobile */
    .product-image {
        width: 100%;
        height: 350px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        border-radius: 20px;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.3s ease;
        border-radius: 20px;
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    /* Perbaikan untuk product-info - ukuran lebih kecil dan responsive */
    .product-info {
        position: absolute;
        bottom: 15px;
        left: 15px;
        right: 15px;
        padding: 12px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transform: translateY(0);
        transition: all 0.3s ease;
    }

    .product-card:hover .product-info {
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .product-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .product-details {
        flex: 1;
    }

    .product-name {
        color: #000;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 3px;
        line-height: 1.2;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .product-price {
        color: #666;
        font-size: 12px;
        font-weight: 500;
        margin: 0;
    }

    .product-arrow {
        background: rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-left: 8px;
        flex-shrink: 0;
    }

    .product-arrow:hover {
        background: rgba(0, 0, 0, 0.1);
        transform: translateX(3px);
    }

    .product-arrow svg {
        width: 12px;
        height: 12px;
        color: #333;
    }

    /* Outfit Grid */
    .outfit-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
        margin-top: 40px;
    }

    .outfit-card {
        background-color: #ffffff;
        overflow: hidden;
    }

    .outfit-content {
        display: flex;
        align-items: center;
        gap: 0;
        height: 200px;
    }

    .outfit-left .outfit-content {
        flex-direction: row;
    }

    .outfit-right .outfit-content {
        flex-direction: row-reverse;
    }

    .outfit-image {
        flex: 0 0 40%;
        height: 100%;
        overflow: hidden;
        position: relative;
    }

    .outfit-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .outfit-text {
        flex: 1;
        padding: 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding-bottom: 28px;
    }

    .outfit-title {
        font-size: 18px;
        font-weight: bold;
        color: #000000;
        margin-bottom: 130px;
        line-height: 1.4;
    }

    .outfit-date {
        font-size: 14px;
        color: #6c757d;
        margin: 0;
    }

    /* Filter Buttons - tetap horizontal di mobile */
    .filter-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
        margin-bottom: 50px;
        flex-wrap: wrap;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        padding: 0 10px;
        scroll-behavior: smooth;
    }

    .filter-btn {
        padding: 10px 25px;
        border: 2px solid #000000;
        background-color: transparent;
        color: #000000;
        border-radius: 50px;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
        flex-shrink: 0;
        min-width: 80px;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background-color: #000000;
        color: #ffffff;
    }

    /* Products Grid (Collections) - Same styles as Best Seller */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        margin-bottom: 40px;
    }

    .products-grid .product-card {
        background-color: transparent;
        border-radius: 20px;
        overflow: visible;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        position: relative;
        text-decoration: none;
        display: block;
    }

    .products-grid .product-card:hover {
        transform: translateY(-5px);
        text-decoration: none;
    }

    .products-grid .product-image {
        width: 100%;
        height: 350px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        border-radius: 20px;
    }

    .products-grid .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.3s ease;
        border-radius: 20px;
    }

    .products-grid .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .products-grid .product-info {
        position: absolute;
        bottom: 15px;
        left: 15px;
        right: 15px;
        padding: 12px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transform: translateY(0);
        transition: all 0.3s ease;
    }

    .products-grid .product-card:hover .product-info {
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .products-grid .product-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .products-grid .product-details {
        flex: 1;
    }

    .products-grid .product-name {
        color: #000;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 3px;
        line-height: 1.2;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .products-grid .product-price {
        color: #666;
        font-size: 12px;
        font-weight: 500;
        margin: 0;
    }

    .products-grid .product-arrow {
        background: rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-left: 8px;
        flex-shrink: 0;
    }

    .products-grid .product-arrow:hover {
        background: rgba(0, 0, 0, 0.1);
        transform: translateX(3px);
    }

    .products-grid .product-arrow svg {
        width: 12px;
        height: 12px;
        color: #333;
    }

    /* See All Button */
    .see-all-container {
        text-align: center;
        margin-top: 40px;
    }

    .see-all-btn {
        color: #000000;
        font-size: 16px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .see-all-btn:hover {
        color: #6c757d;
    }

    /* Featured Section */
    .featured-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }

    .featured-card {
        border-radius: 12px;
        overflow: hidden;
        height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .featured-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .featured-universe {
        background-color: #343a40;
        color: #ffffff;
    }

    .featured-minimalist {
        background-color: #f8f9fa;
        color: #000000;
        border: 1px solid #e9ecef;
    }

    .featured-marvel {
        background: linear-gradient(135deg, #7c3aed, #2563eb);
        color: #ffffff;
    }

    .featured-future {
        background-color: #212529;
        color: #ffffff;
    }

    .featured-content {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .featured-content h4 {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .featured-content p {
        opacity: 0.7;
    }

    .featured-content img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 0;
        display: block;
        transition: none !important;
        transform: none !important;
    }

    .featured-card:hover .featured-content img,
    .featured-card .featured-content img:hover {
        transform: none !important;
        scale: none !important;
    }

    /* Loading Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .product-card,
    .outfit-card,
    .featured-card {
        animation: fadeInUp 0.6s ease forwards;
    }

    /* Large devices (desktops, 1200px and up) */
    @media (max-width: 1200px) {
        .container {
            max-width: 1000px;
        }

        .hero-title {
            font-size: 3rem;
            margin-top: 50px;
        }

        .hero-subtitle {
            font-size: 2.5rem;
        }
    }

    /* Medium devices (tablets, 992px and up) */
    @media (max-width: 992px) {
        .container {
            max-width: 100%;
            padding: 0 15px;
        }

        .hero-title {
            font-size: 2.8rem;
            margin-top: 50px;
        }

        .hero-subtitle {
            font-size: 2.2rem;
        }

        .section-title {
            font-size: 1.8rem;
            text-align: center;
        }

        .hero-section {
            padding: 60px 0;
        }

        .section {
            padding: 50px 0;
        }

        .product-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .products-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .product-image {
            height: 300px;
        }

        .products-grid .product-image {
            height: 300px;
        }

        .product-info {
            bottom: 12px;
            left: 12px;
            right: 12px;
            padding: 10px;
        }

        .products-grid .product-info {
            bottom: 12px;
            left: 12px;
            right: 12px;
            padding: 10px;
        }

        .filter-container {
            gap: 12px;
            margin-bottom: 40px;
        }

        .filter-btn {
            padding: 9px 22px;
            font-size: 14px;
        }

        .featured-grid {
            gap: 20px;
        }
    }

    /* Small devices (landscape phones, 768px and up) */
    @media (max-width: 768px) {
        .container {
            padding: 0 15px;
        }

        .hero-section {
            padding: 50px 0;
        }

        .section {
            padding: 40px 0;
        }

        .hero-title {
            font-size: 2.2rem;
            margin-bottom: 15px;
            margin-top: 50px;
        }

        .hero-subtitle {
            font-size: 1.8rem;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.6rem;
            margin-bottom: 30px;
        }

        .btn-primary {
            padding: 12px 30px;
            font-size: 15px;
        }

        .product-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .products-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .product-image {
            height: 280px;
        }

        .products-grid .product-image {
            height: 280px;
        }

        .product-info {
            bottom: 10px;
            left: 10px;
            right: 10px;
            padding: 8px;
            border-radius: 10px;
        }

        .products-grid .product-info {
            bottom: 10px;
            left: 10px;
            right: 10px;
            padding: 8px;
            border-radius: 10px;
        }

        .product-name {
            font-size: 13px;
        }

        .products-grid .product-name {
            font-size: 13px;
        }

        .product-price {
            font-size: 11px;
        }

        .products-grid .product-price {
            font-size: 11px;
        }

        .product-arrow {
            width: 26px;
            height: 26px;
            margin-left: 6px;
        }

        .products-grid .product-arrow {
            width: 26px;
            height: 26px;
            margin-left: 6px;
        }

        .product-arrow svg {
            width: 11px;
            height: 11px;
        }

        .products-grid .product-arrow svg {
            width: 11px;
            height: 11px;
        }

        .outfit-grid {
            grid-template-columns: 1fr;
            gap: 25px;
        }

        .outfit-content {
            flex-direction: column !important;
            height: auto;
        }

        .outfit-image {
            flex: none;
            width: 100%;
            height: 200px;
        }

        .outfit-text {
            padding: 20px;
        }

        .outfit-title {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .outfit-date {
            font-size: 13px;
        }

        .featured-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .featured-card {
            height: 200px;
        }

        /* Filter container tetap horizontal */
        .filter-container {
            justify-content: flex-start;
            gap: 10px;
            margin-bottom: 30px;
            padding: 0 15px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .filter-container::-webkit-scrollbar {
            display: none;
        }

        .filter-btn {
            padding: 8px 20px;
            font-size: 13px;
            min-width: 70px;
        }

        .sale-badge,
        .bestseller-badge {
            top: 8px;
            padding: 3px 6px;
            font-size: 9px;
        }

        .sale-badge {
            left: 8px;
        }

        .bestseller-badge {
            right: 8px;
        }

        .product-price-original {
            font-size: 9px;
        }

        .product-sales {
            font-size: 9px;
        }

        .rating-stars {
            font-size: 11px;
        }

        .rating-value {
            font-size: 9px;
        }

    }

    /* Extra small devices (portrait phones, 576px and down) */
    @media (max-width: 576px) {
        .container {
            padding: 0 10px;
        }

        .hero-section {
            padding: 40px 0;
        }

        .section {
            padding: 35px 0;
        }

        .hero-title {
            font-size: 1.8rem;
            margin-bottom: 10px;
            line-height: 1.1;
            margin-top: 50px;
        }

        .hero-subtitle {
            font-size: 1.4rem;
            margin-bottom: 25px;
            line-height: 1.1;
        }

        .section-title {
            font-size: 1.4rem;
            margin-bottom: 25px;
        }

        .btn-primary {
            padding: 10px 25px;
            font-size: 14px;
        }

        .product-grid {
            gap: 15px;
        }

        .products-grid {
            gap: 15px;
        }

        .product-image {
            height: 240px;
        }

        .products-grid .product-image {
            height: 240px;
        }

        .product-info {
            bottom: 8px;
            left: 8px;
            right: 8px;
            padding: 6px 8px;
            border-radius: 8px;
        }

        .products-grid .product-info {
            bottom: 8px;
            left: 8px;
            right: 8px;
            padding: 6px 8px;
            border-radius: 8px;
        }

        .product-content {
            gap: 6px;
        }

        .products-grid .product-content {
            gap: 6px;
        }

        .product-name {
            font-size: 12px;
            margin-bottom: 2px;
        }

        .products-grid .product-name {
            font-size: 12px;
            margin-bottom: 2px;
        }

        .product-price {
            font-size: 10px;
        }

        .products-grid .product-price {
            font-size: 10px;
        }

        .product-arrow {
            width: 24px;
            height: 24px;
            margin-left: 4px;
        }

        .products-grid .product-arrow {
            width: 24px;
            height: 24px;
            margin-left: 4px;
        }

        .product-arrow svg {
            width: 10px;
            height: 10px;
        }

        .products-grid .product-arrow svg {
            width: 10px;
            height: 10px;
        }

        .outfit-grid {
            gap: 20px;
        }

        .outfit-image {
            height: 180px;
        }

        .outfit-text {
            padding: 15px;
        }

        .outfit-title {
            font-size: 15px;
            margin-bottom: 8px;
        }

        .outfit-date {
            font-size: 12px;
        }

        /* Filter container dengan scroll horizontal */
        .filter-container {
            justify-content: flex-start;
            gap: 8px;
            margin-bottom: 25px;
            padding: 0 10px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            white-space: nowrap;
        }

        .filter-btn {
            padding: 6px 16px;
            font-size: 12px;
            min-width: 60px;
            display: inline-block;
        }

        .see-all-container {
            margin-top: 30px;
        }

        .see-all-btn {
            font-size: 15px;
        }

        .sale-badge,
        .bestseller-badge {
            top: 6px;
            padding: 2px 5px;
            font-size: 8px;
        }

        .sale-badge {
            left: 6px;
        }

        .bestseller-badge {
            right: 6px;
        }

        .product-price-original {
            font-size: 8px;
        }

        .product-sales {
            font-size: 8px;
        }

        .rating-stars {
            font-size: 10px;
        }

        .rating-value {
            font-size: 8px;
        }

    }

    /* Extra extra small devices (very small phones, 400px and down) */
    @media (max-width: 400px) {
        .hero-title {
            font-size: 1.6rem;
            margin-top: 50px;
        }

        .hero-subtitle {
            font-size: 1.2rem;
        }

        .section-title {
            font-size: 1.3rem;
        }

        .product-image {
            height: 220px;
        }

        .products-grid .product-image {
            height: 220px;
        }

        .product-info {
            bottom: 6px;
            left: 6px;
            right: 6px;
            padding: 5px 6px;
        }

        .products-grid .product-info {
            bottom: 6px;
            left: 6px;
            right: 6px;
            padding: 5px 6px;
        }

        .product-name {
            font-size: 11px;
        }

        .products-grid .product-name {
            font-size: 11px;
        }

        .product-price {
            font-size: 9px;
        }

        .products-grid .product-price {
            font-size: 9px;
        }

        .product-arrow {
            width: 22px;
            height: 22px;
        }

        .products-grid .product-arrow {
            width: 22px;
            height: 22px;
        }

        .product-arrow svg {
            width: 9px;
            height: 9px;
        }

        .products-grid .product-arrow svg {
            width: 9px;
            height: 9px;
        }

        .outfit-image {
            height: 160px;
        }

        .featured-card {
            height: 160px;
        }

        .filter-btn {
            padding: 5px 14px;
            font-size: 11px;
            min-width: 50px;
        }
    }

    /* Perbaikan viewport yang sangat kecil */
    @media (max-width: 320px) {
        .container {
            padding: 0 8px;
        }

        .product-grid {
            gap: 12px;
        }

        .products-grid {
            gap: 12px;
        }

        .product-image {
            height: 200px;
        }

        .products-grid .product-image {
            height: 200px;
        }

        .filter-container {
            padding: 0 8px;
            gap: 6px;
        }

        .filter-btn {
            padding: 4px 12px;
            font-size: 10px;
            min-width: 45px;
        }
    }

    /* Landscape orientation untuk mobile */
    @media (max-height: 500px) and (orientation: landscape) {
        .hero-section {
            padding: 30px 0;
        }

        .section {
            padding: 25px 0;
        }

        .hero-title {
            font-size: 1.8rem;
            margin-bottom: 8px;
        }

        .hero-subtitle {
            font-size: 1.4rem;
            margin-bottom: 20px;
        }
    }

    /* Perbaikan khusus untuk Android Chrome */
    @media screen and (-webkit-min-device-pixel-ratio: 1) {
        .product-image img {
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }

        .products-grid .product-image img {
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }
    }

    /* Tambahan untuk memastikan gambar tidak blur di perangkat high-DPI */
    @media (-webkit-min-device-pixel-ratio: 2),
    (min-resolution: 192dpi) {
        .product-image img {
            image-rendering: -webkit-optimize-contrast;
        }

        .products-grid .product-image img {
            image-rendering: -webkit-optimize-contrast;
        }
    }

    .get a {
        text-decoration: none;
        color: white;
    }

    /* Badges */
    .sale-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: #dc3545;
        color: white;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 600;
        z-index: 2;
        text-transform: uppercase;
    }

    .bestseller-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #ffc107;
        color: #000;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 600;
        z-index: 2;
        text-transform: uppercase;
    }

    /* Product pricing with original price */
    .product-pricing {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .product-price-original {
        color: #999;
        font-size: 10px;
        font-weight: 400;
        text-decoration: line-through;
        margin: 0;
    }

    .product-price {
        color: #666;
        font-size: 12px;
        font-weight: 500;
        margin: 0;
    }

    /* Sales count */
    .product-sales {
        color: #28a745;
        font-size: 10px;
        font-weight: 500;
        margin: 2px 0 0 0;
    }

    /* Rating stars */
    .product-rating {
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 3px;
    }

    .rating-stars {
        color: #ffc107;
        font-size: 12px;
        line-height: 1;
    }

    .rating-value {
        color: #666;
        font-size: 10px;
        font-weight: 400;
    }

    /* No products fallback */
    .no-products {
        grid-column: 1 / -1;
        text-align: center;
        padding: 40px;
        color: #666;
    }

    .no-products p {
        font-size: 16px;
        margin: 0;
    }


    /* ============================================
   ALLPRODUK.BLADE.PHP - DISCOUNT STYLES
   ============================================ */

    /* Discount Badge Styles */
    .sale-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: #dc3545;
        color: white;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 600;
        z-index: 2;
        text-transform: uppercase;
    }

    /* Gradient badge for active discounts */
    .sale-badge[style*="gradient"] {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4);
    }

    .bestseller-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #ffc107;
        color: #000;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 600;
        z-index: 2;
        text-transform: uppercase;
    }

    /* Product Pricing Section */
    .product-pricing {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .product-price-original {
        color: #999;
        font-size: 10px;
        font-weight: 400;
        text-decoration: line-through;
        margin: 0;
    }

    .product-price {
        color: #666;
        font-size: 12px;
        font-weight: 500;
        margin: 0;
    }

    /* Discounted Price Highlight */
    .product-price[style*="dc3545"] {
        color: #dc3545 !important;
        font-weight: 600 !important;
    }

    /* Savings Info */
    .product-savings,
    span[style*="28a745"] {
        display: block;
        color: #28a745;
        font-size: 9px;
        font-weight: 500;
        margin-top: 2px;
    }

    /* Product Sales Count */
    .product-sales {
        color: #28a745;
        font-size: 10px;
        font-weight: 500;
        margin: 2px 0 0 0;
    }

    /* Rating Stars */
    .product-rating {
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 3px;
    }

    .rating-stars {
        color: #ffc107;
        font-size: 12px;
        line-height: 1;
    }

    .rating-value {
        color: #666;
        font-size: 10px;
        font-weight: 400;
    }

    /* Tablet Responsive */
    @media (max-width: 992px) {

        .sale-badge,
        .bestseller-badge {
            padding: 3px 7px;
            font-size: 9px;
        }

        .product-price-original {
            font-size: 9px;
        }

        .product-price {
            font-size: 11px;
        }

        .product-savings {
            font-size: 8px;
        }
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {

        .sale-badge,
        .bestseller-badge {
            top: 8px;
            padding: 3px 6px;
            font-size: 9px;
        }

        .sale-badge {
            left: 8px;
        }

        .bestseller-badge {
            right: 8px;
        }

        .product-price-original {
            font-size: 9px;
        }

        .product-price {
            font-size: 10px;
        }

        .product-savings {
            font-size: 9px;
        }

        .product-sales {
            font-size: 9px;
        }

        .rating-stars {
            font-size: 10px;
        }

        .rating-value {
            font-size: 9px;
        }
    }

    /* Small Mobile Responsive */
    @media (max-width: 576px) {

        .sale-badge,
        .bestseller-badge {
            top: 6px;
            padding: 2px 5px;
            font-size: 8px;
        }

        .sale-badge {
            left: 6px;
        }

        .bestseller-badge {
            right: 6px;
        }

        .product-price-original {
            font-size: 8px;
        }

        .product-price {
            font-size: 9px;
        }

        .product-savings {
            font-size: 8px;
        }

        .product-sales {
            font-size: 8px;
        }

        .rating-stars {
            font-size: 10px;
        }

        .rating-value {
            font-size: 8px;
        }
    }


    /* Compact Timer Styles for Product Cards */
    .product-card .discount-timer-container {
        margin-top: 6px;
        padding: 6px 8px;
        background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);
        border: 1px solid #ffc107;
        border-radius: 6px;
    }

    .product-card .discount-timer-display {
        gap: 6px;
    }

    .product-card .timer-icon {
        width: 14px;
        height: 14px;
    }

    .product-card .timer-label {
        font-size: 8px;
        margin-bottom: 3px;
    }

    .product-card .timer-countdown {
        gap: 2px;
    }

    .product-card .time-block {
        padding: 2px 4px;
        min-width: 24px;
    }

    .product-card .time-value {
        font-size: 11px;
    }

    .product-card .time-unit {
        font-size: 6px;
        margin-top: 1px;
    }

    .product-card .time-separator {
        font-size: 11px;
    }

    /* Hide timer on very small cards */
    @media (max-width: 480px) {
        .product-card .timer-label {
            display: none;
        }

        .product-card .time-unit {
            font-size: 5px;
        }
    }
</style>

<div class="allproduk-container">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1 class="hero-title">
                The New Innovation:
            </h1>
            <h2 class="hero-subtitle">
                Form Chaos To Cosmos
            </h2>
            <button class="btn-primary get">
                <a href="#produk-display">Get Started</a>
            </button>
        </div>
    </div>

    <!-- Best Seller Section -->
    <div class="section">
        <div class="container">
            <h3 class="section-title">Best Seller</h3>
            <div class="product-grid">
                @forelse ($bestSellerProducts as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="product-image">
                        @if ($product->primaryImage)
                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                            alt="{{ $product->name }}">
                        @elseif ($product->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                            alt="{{ $product->name }}">
                        @else
                        <img src="{{ asset('images/no-image.png') }}"
                            onerror="this.onerror=null;this.src='https://via.placeholder.com/300x300?text=No+Image';"
                            alt="No Image">
                        @endif

                        <!-- 🔥 UPDATED: Discount Badge -->
                        @if($product->hasActiveDiscount())
                        <div class="sale-badge" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);">
                            {{ $product->getDiscountLabel() }}
                        </div>
                        @elseif($product->is_on_sale)
                        <div class="sale-badge">Sale</div>
                        @endif

                        <!-- Best Seller Badge -->
                        @if ($product->total_penjualan > 0)
                        <div class="bestseller-badge">
                            #{{ $loop->iteration }} Best Seller
                        </div>
                        @endif
                    </div>
                    <div class="product-info">
                        <div class="product-content">
                            <div class="product-details">
                                <h4 class="product-name">{{ $product->name }}</h4>
                                <div class="product-pricing">
                                    @if($product->hasActiveDiscount() || $product->is_on_sale)
                                    <span class="product-price-original">
                                        IDR {{ number_format($product->getOriginalPrice(), 0, ',', '.') }}
                                    </span>
                                    <span class="product-price" style="color: #dc3545 !important; font-weight: 600 !important;">
                                        IDR {{ number_format($product->final_price, 0, ',', '.') }}
                                    </span>
                                    @if($product->hasActiveDiscount())
                                    <span style="display: block; color: #28a745; font-size: 9px; font-weight: 500; margin-top: 2px;">
                                        Save IDR {{ number_format($product->getDiscountAmount(), 0, ',', '.') }}
                                    </span>
                                    @endif
                                    @else
                                    <span class="product-price">
                                        IDR {{ number_format($product->final_price, 0, ',', '.') }}
                                    </span>
                                    @endif
                                </div>

                                @if($product->hasActiveDiscount() && $product->discount_end_date)
                                <div style="margin-top: 6px;">
                                    <x-discount-timer :product="$product" />
                                </div>
                                @endif

                                <!-- Sales count -->
                                @if ($product->total_penjualan > 0)
                                <p class="product-sales">{{ $product->total_penjualan }} sold</p>
                                @endif

                                <!-- Rating (if available) -->
                                @if ($product->rating_rata > 0)
                                <div class="product-rating">
                                    <span class="rating-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <=floor($product->rating_rata))
                                            ★
                                            @elseif ($i - 0.5 <= $product->rating_rata)
                                                ☆
                                                @else
                                                ☆
                                                @endif
                                                @endfor
                                    </span>
                                    <span class="rating-value">({{ number_format($product->rating_rata, 1) }})</span>
                                </div>
                                @endif
                            </div>
                            <div class="product-arrow">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14m-7-7 7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <!-- Fallback jika tidak ada produk -->
                <div class="no-products">
                    <p>No best seller products available at the moment.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Inspirational Outfits Section -->
    <div class="section">
        <div class="container">
            <h3 class="section-title">Inspirational Outfits</h3>
            <div class="outfit-grid">
                <!-- Outfit 1 -->
                <div class="outfit-card outfit-left">
                    <div class="outfit-content">
                        <div class="outfit-image">
                            <img src=" image/inspirasi1.jpg" alt="Build For The Grind Outfit">
                        </div>
                        <div class="outfit-text">
                            <h4 class="outfit-title">"Dare To Win" For The Dedicated Individuals</h4>
                            <p class="outfit-date">June 5, 2025</p>
                        </div>
                    </div>
                </div>

                <!-- Outfit 2 -->
                <div class="outfit-card outfit-right">
                    <div class="outfit-content">
                        <div class="outfit-text">
                            <h4 class="outfit-title">Made For Those Who Are Silent But Resilient</h4>
                            <p class="outfit-date">July 10, 2025</p>
                        </div>
                        <div class="outfit-image">
                            <img src=" image/inspirasi2.jpg" alt="Silent But Resilient Outfit">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Collections Section -->
    <div class="section">
        <div class="container" id="produk-display">
            <h3 class="section-title">Our Collections</h3>

            <!-- Filter Buttons -->
            <div class="filter-container">
                <button class="filter-btn active" data-filter="all" data-category-id="">All</button>
                <button class="filter-btn" data-filter="all" data-category-id="">T-Shirt</button>
                <button class="filter-btn" data-filter="hoodie" data-category-id="1">Hoodie</button>
                <button class="filter-btn" data-filter="shoes" data-category-id="2">Shoes</button>
            </div>

            <!-- Products Grid -->
            <div class="products-grid">
                @foreach ($products as $product)
                <a href="{{ route('products.show', $product->slug) }}"
                    class="product-card"
                    data-category="{{ $product->category?->name }}"
                    data-category-id="{{ $product->category_id }}">
                    <div class="product-image">
                        @if ($product->primaryImage)
                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                            alt="{{ $product->name }}">
                        @elseif ($product->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                            alt="{{ $product->name }}">
                        @else
                        <img src="{{ asset('images/no-image.png') }}"
                            onerror="this.onerror=null;this.src='https://via.placeholder.com/300x300?text=No+Image';"
                            alt="No Image">
                        @endif

                        <!-- 🔥 Discount/Sale Badge -->
                        @if($product->hasActiveDiscount())
                        <div class="sale-badge" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);">
                            {{ $product->getDiscountLabel() }}
                        </div>
                        @elseif($product->is_on_sale)
                        <div class="sale-badge">Sale</div>
                        @endif
                    </div>
                    <div class="product-info">
                        <div class="product-content">
                            <div class="product-details">
                                <h4 class="product-name">{{ $product->name }}</h4>
                                <div class="product-pricing">
                                    @if($product->hasActiveDiscount() || $product->is_on_sale)
                                    <span class="product-price-original">
                                        IDR {{ number_format($product->getOriginalPrice(), 0, ',', '.') }}
                                    </span>
                                    <span class="product-price" style="color: #dc3545 !important; font-weight: 600 !important;">
                                        IDR {{ number_format($product->final_price, 0, ',', '.') }}
                                    </span>
                                    @else
                                    <span class="product-price">
                                        IDR {{ number_format($product->final_price, 0, ',', '.') }}
                                    </span>
                                    @endif
                                </div>

                                @if($product->hasActiveDiscount() && $product->discount_end_date)
                                <div style="margin-top: 6px;">
                                    <x-discount-timer :product="$product" />
                                </div>
                                @endif
                            </div>
                            <div class="product-arrow">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14m-7-7 7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>


            <!-- See All Button -->
            <div class="see-all-container">
                <a href="#" class="see-all-btn">See All →</a>
            </div>
        </div>
    </div>

    <!-- Featured Section -->
    <div class="section">
        <div class="container">
            <h3 class="section-title">Featured</h3>
            <div class="featured-grid">
                <!-- Featured Item 1 -->
                <div class="featured-card featured-universe">
                    <div class="featured-content">
                        <img src=" image/banner2.jpg">
                    </div>
                </div>

                <!-- Featured Item 2 -->
                <div class="featured-card featured-minimalist">
                    <div class="featured-content">
                        <img src=" image/banner-sepatu.jpg">
                    </div>
                </div>

                <!-- Featured Item 3 -->
                <div class="featured-card featured-marvel">
                    <div class="featured-content">
                        <img src=" image/banner-sepatu2.jpg">
                    </div>
                </div>

                <!-- Featured Item 4 -->
                <div class="featured-card featured-future">
                    <div class="featured-content">
                        <img src=" image/banner-hoodie.jpg">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="path/to/dynamic-search.js"></script>
<script>
    // Search form handler untuk redirect ke produk detail atau search results
    document.addEventListener('DOMContentLoaded', function() {
        // Cari semua form search di halaman
        const searchForms = document.querySelectorAll('form[action*="search"], .search-form, #search-form');

        searchForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Dapatkan search input
                const searchInput = this.querySelector('input[name="q"], input[type="search"], .search-input');
                const searchTerm = searchInput ? searchInput.value.trim() : '';

                if (searchTerm) {
                    // Buat URL dengan parameter pencarian
                    const searchUrl = new URL('/search', window.location.origin);
                    searchUrl.searchParams.set('q', searchTerm);

                    // Jika ada category filter
                    const categorySelect = this.querySelector('select[name="category_id"]');
                    if (categorySelect && categorySelect.value) {
                        searchUrl.searchParams.set('category_id', categorySelect.value);
                    }

                    // Redirect ke search page
                    window.location.href = searchUrl.toString();
                }
            });
        });

        // Handle search bar dengan Enter key
        const searchInputs = document.querySelectorAll('input[name="q"], input[type="search"], .search-input');

        searchInputs.forEach(input => {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const searchTerm = this.value.trim();

                    if (searchTerm) {
                        const searchUrl = new URL('/search', window.location.origin);
                        searchUrl.searchParams.set('q', searchTerm);
                        window.location.href = searchUrl.toString();
                    }
                }
            });
        });
    });

    // Function untuk handle search dari navbar atau search bar lainnya
    function handleSearch(searchTerm, categoryId = '') {
        if (searchTerm && searchTerm.trim()) {
            const searchUrl = new URL('/search', window.location.origin);
            searchUrl.searchParams.set('q', searchTerm.trim());

            if (categoryId) {
                searchUrl.searchParams.set('category_id', categoryId);
            }

            window.location.href = searchUrl.toString();
        }
    }
</script>
@endsection