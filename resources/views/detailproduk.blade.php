<?php

use App\Models\Product;
?>
@extends('layouts.app2')

@section('content')
<!-- CSRF token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .product-detail-container {
        background-color: #f8f9fa;
        min-height: 100vh;
        font-family: 'Arial', sans-serif;
        padding: 60px 0;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        margin-top: 50px;
    }

    /* Back Button */
    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: white;
        color: #6c757d;
        text-decoration: none;
        padding: 12px 20px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 500;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        margin-bottom: 40px;
        border: 1px solid #e9ecef;
    }

    .back-button:hover {
        background: #f8f9fa;
        color: #495057;
        transform: translateX(-2px);
        text-decoration: none;
    }

    /* Main Product Section */
    .product-detail-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
    }

    .product-main {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: start;
    }

    /* Product Images */
    .product-images {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .main-image {
        width: 100%;
        height: 500px;
        background: #f8f9fa;
        border-radius: 16px;
        overflow: hidden;
        position: relative;
        border: 1px solid #e9ecef;
    }

    .main-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: opacity 0.3s ease;
    }

    /* Slideshow Thumbnail Container */
    .thumbnail-slideshow {
        position: relative;
        overflow: hidden;
    }

    .thumbnail-container {
        display: flex;
        transition: transform 0.3s ease;
        gap: 15px;
    }

    .thumbnail {
        flex: 0 0 calc(25% - 11.25px);
        /* 4 thumbnails per view */
        height: 100px;
        background: #f8f9fa;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .thumbnail:hover,
    .thumbnail.active {
        border-color: #000;
    }

    .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Slideshow Navigation */
    .slideshow-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
    }

    .nav-button {
        background: white;
        border: 2px solid #e9ecef;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .nav-button:hover:not(:disabled) {
        border-color: #212529;
        background: #f8f9fa;
    }

    .nav-button:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    .nav-button svg {
        width: 16px;
        height: 16px;
        stroke: currentColor;
    }

    .slideshow-dots {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #e9ecef;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .dot.active {
        background: #212529;
        transform: scale(1.2);
    }

    /* Hide navigation when there are 4 or fewer images */
    .thumbnail-slideshow.no-navigation .slideshow-nav {
        display: none;
    }

    /* Product Info */
    .product-info {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .product-title {
        font-size: 2rem;
        font-weight: bold;
        color: #212529;
        line-height: 1.2;
    }

    .product-description {
        color: #6c757d;
        font-size: 16px;
        line-height: 1.6;
    }

    .product-rating {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .stars {
        display: flex;
        gap: 2px;
    }

    .star {
        width: 20px;
        height: 20px;
        color: #ffc107;
        fill: currentColor;
    }

    .rating-text {
        color: #6c757d;
        font-size: 14px;
    }

    .product-price {
        font-size: 2rem;
        font-weight: bold;
        color: #212529;
    }

    /* Color & Size Selection */
    .color-section,
    .size-section {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .section-label {
        font-weight: 600;
        color: #212529;
        font-size: 16px;
    }

    .color-options {
        display: flex;
        gap: 10px;
    }

    .color-option {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        border: 3px solid transparent;
        transition: all 0.3s ease;
    }

    .color-option.active {
        border-color: #212529;
        transform: scale(1.1);
    }

    .size-options {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .size-option {
        padding: 12px 20px;
        border: 2px solid #e9ecef;
        background: white;
        color: #6c757d;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s ease;
        min-width: 50px;
        text-align: center;
    }

    .size-option:hover {
        border-color: #212529;
        color: #212529;
    }

    .size-option.active {
        background: #212529;
        color: white;
        border-color: #212529;
    }

    /* Actions - Updated with Buy Now Button */
    .product-actions {
        display: flex;
        gap: 15px;
        align-items: center;
        margin-top: 20px;
    }

    .add-to-cart-btn,
    .buy-now-btn {
        flex: 1;
        border: none;
        padding: 16px 24px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .add-to-cart-btn {
        background: #212529;
        color: white;
    }

    .add-to-cart-btn:hover:not(:disabled) {
        background: #343a40;
        transform: translateY(-2px);
    }

    .add-to-cart-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Buy Now Button Styles */
    .buy-now-btn {
        background: #dc3545;
        color: white;
        border: 2px solid #dc3545;
    }

    .buy-now-btn:hover:not(:disabled) {
        background: #c82333;
        border-color: #c82333;
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    .buy-now-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        background: #6c757d;
        border-color: #6c757d;
    }

    .wishlist-btn {
        width: 56px;
        height: 56px;
        border: 2px solid #e9ecef;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .wishlist-btn:hover {
        border-color: #212529;
        background: #f8f9fa;
    }

    .wishlist-btn svg {
        width: 20px;
        height: 20px;
    }

    .delivery-info {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 16px 0;
        color: #6c757d;
        font-size: 14px;
        border-top: 1px solid #e9ecef;
        margin-top: 20px;
    }

    .delivery-info svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }

    /* Reviews Section */
    .reviews-section {
        margin-top: 80px;
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #212529;
        margin-bottom: 30px;
        text-align: center;
    }

    /* Review Summary */
    .review-summary {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 60px;
        padding-bottom: 40px;
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 40px;
    }

    .overall-rating {
        text-align: center;
    }

    .rating-number {
        font-size: 3rem;
        font-weight: bold;
        color: #212529;
        display: block;
        margin-bottom: 15px;
    }

    .rating-stars-large {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin-bottom: 15px;
    }

    .star-large {
        width: 28px;
        height: 28px;
        color: #ffc107;
        fill: currentColor;
    }

    .review-count {
        color: #6c757d;
        font-size: 14px;
        margin: 0;
    }

    .rating-distribution {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .rating-row {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .rating-label {
        width: 60px;
        font-size: 14px;
        color: #6c757d;
        text-align: right;
    }

    .rating-bar {
        flex: 1;
        height: 8px;
        background: #f8f9fa;
        border-radius: 4px;
        overflow: hidden;
    }

    .rating-fill {
        height: 100%;
        background: #ffc107;
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    .rating-count-small {
        width: 30px;
        font-size: 14px;
        color: #6c757d;
        text-align: center;
    }

    .recommendation-rate {
        margin-top: 25px;
        padding-top: 25px;
        border-top: 1px solid #f8f9fa;
        text-align: center;
    }

    .recommendation-percentage {
        font-size: 1.5rem;
        font-weight: bold;
        color: #28a745;
        display: block;
        margin-bottom: 5px;
    }

    .recommendation-text {
        color: #6c757d;
        font-size: 14px;
    }

    /* Reviews List */
    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .review-item {
        padding: 25px 0;
        border-bottom: 1px solid #f8f9fa;
    }

    .review-item:last-child {
        border-bottom: none;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .reviewer-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .reviewer-avatar {
        width: 50px;
        height: 50px;
        background: #6c757d;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
    }

    .reviewer-details {
        flex: 1;
    }

    .reviewer-name {
        font-size: 16px;
        font-weight: 600;
        color: #212529;
        margin: 0 0 8px 0;
    }

    .review-meta {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .review-rating {
        display: flex;
        gap: 2px;
    }

    .star-small {
        width: 16px;
        height: 16px;
        color: #ffc107;
        fill: currentColor;
    }

    .review-date {
        color: #6c757d;
        font-size: 13px;
    }

    .verified-badge {
        background: #28a745;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
    }

    .recommended-badge {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #28a745;
        font-size: 13px;
        font-weight: 500;
    }

    .recommended-badge svg {
        width: 16px;
        height: 16px;
        stroke: currentColor;
    }

    .review-content {
        margin-bottom: 15px;
    }

    .review-content p {
        color: #495057;
        line-height: 1.6;
        margin: 0;
    }

    .review-images {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .review-image {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .review-image:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .review-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .no-reviews {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }

    .no-reviews svg {
        width: 64px;
        height: 64px;
        color: #dee2e6;
        margin-bottom: 20px;
    }

    .no-reviews h4 {
        font-size: 1.25rem;
        color: #495057;
        margin-bottom: 10px;
    }

    .no-reviews p {
        font-size: 14px;
        margin: 0;
    }

    /* Image Modal */
    .image-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        cursor: pointer;
    }

    .image-modal img {
        max-width: 90%;
        max-height: 90%;
        border-radius: 8px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }

    .image-modal.active {
        display: flex;
    }

    /* Related Products */
    .related-section {
        margin-top: 80px;
    }

    .related-products {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
    }

    .related-product {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .related-product:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        text-decoration: none;
        color: inherit;
    }

    .related-image {
        width: 100%;
        height: 200px;
        overflow: hidden;
    }

    .related-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .related-product:hover .related-image img {
        transform: scale(1.05);
    }

    .related-info {
        padding: 20px;
    }

    .related-name {
        font-weight: 600;
        color: #212529;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .related-price {
        color: #6c757d;
        font-size: 14px;
        font-weight: 500;
    }

    /* Spinning animation */
    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .container {
            padding: 0 15px;
        }

        .product-detail-card,
        .reviews-section {
            padding: 30px;
        }

        .product-main {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .review-summary {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .related-products {
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .thumbnail {
            flex: 0 0 calc(33.333% - 10px);
            /* 3 thumbnails per view on tablet */
        }
    }

    @media (max-width: 768px) {
        .product-detail-container {
            padding: 30px 0;
        }

        .product-detail-card,
        .reviews-section {
            padding: 20px;
        }

        .main-image {
            height: 350px;
        }

        .related-products {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .review-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .thumbnail {
            flex: 0 0 calc(50% - 7.5px);
            /* 2 thumbnails per view on mobile */
        }

        /* Mobile: Stack buttons vertically */
        .product-actions {
            flex-direction: column;
            gap: 12px;
        }

        .add-to-cart-btn,
        .buy-now-btn {
            flex: none;
            width: 100%;
        }

        .wishlist-btn {
            align-self: center;
        }
    }

    @media (max-width: 576px) {

        .product-detail-card,
        .reviews-section {
            padding: 15px;
        }

        .main-image {
            height: 280px;
        }

        .related-products {
            grid-template-columns: 1fr;
        }

        .reviewer-info {
            gap: 12px;
        }

        .reviewer-avatar {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .thumbnail {
            flex: 0 0 100%;
            /* 1 thumbnail per view on small mobile */
        }
    }

    .star-small {
        width: 16px;
        height: 16px;
        color: #ffc107;
    }

    /* Filled star */
    .star-small[fill="currentColor"] {
        fill: #ffc107;
    }

    /* Empty star */
    .star-small[fill="none"] {
        fill: none;
    }

    .product-rating {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .stars {
        display: flex;
        gap: 2px;
    }

    .star {
        width: 20px;
        height: 20px;
        color: #ffc107;
        fill: currentColor;
    }

    /* Empty star styling */
    .star[fill="none"] {
        fill: none;
    }

    .rating-text {
        color: #6c757d;
        font-size: 14px;
    }

    .review-summary {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 60px;
        padding-bottom: 40px;
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 40px;
    }

    .overall-rating {
        text-align: center;
    }

    .rating-number {
        font-size: 3rem;
        font-weight: bold;
        color: #212529;
        display: block;
        margin-bottom: 15px;
    }

    .rating-stars-large {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin-bottom: 15px;
    }

    .star-large {
        width: 28px;
        height: 28px;
        color: #ffc107;
    }

    /* Filled star */
    .star-large[fill="currentColor"] {
        fill: #ffc107;
    }

    /* Empty star */
    .star-large[fill="none"] {
        fill: none;
    }

    .review-count {
        color: #6c757d;
        font-size: 14px;
        margin: 0;
    }

    .rating-distribution {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .rating-row {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .rating-label {
        width: 60px;
        font-size: 14px;
        color: #6c757d;
        text-align: right;
    }

    .rating-bar {
        flex: 1;
        height: 8px;
        background: #f8f9fa;
        border-radius: 4px;
        overflow: hidden;
    }

    .rating-fill {
        height: 100%;
        background: #ffc107;
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    .rating-count-small {
        width: 30px;
        font-size: 14px;
        color: #6c757d;
        text-align: center;
    }

    .recommendation-rate {
        margin-top: 25px;
        padding-top: 25px;
        border-top: 1px solid #f8f9fa;
        text-align: center;
    }

    .recommendation-percentage {
        font-size: 1.5rem;
        font-weight: bold;
        color: #28a745;
        display: block;
        margin-bottom: 5px;
    }

    .recommendation-text {
        color: #6c757d;
        font-size: 14px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .review-summary {
            grid-template-columns: 1fr;
            gap: 40px;
        }
    }



    /* ============================================
   DETAILPRODUK.BLADE.PHP - DISCOUNT STYLES
   ============================================ */

    /* Product Price Section */
    .product-price-section {
        margin: 20px 0;
    }

    /* Discount Badge with Animation */
    .discount-badge {
        display: inline-block;
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 12px;
        box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
        animation: pulse-subtle 2s ease-in-out infinite;
    }

    @keyframes pulse-subtle {

        0%,
        100% {
            transform: scale(1);
            box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
        }

        50% {
            transform: scale(1.02);
            box-shadow: 0 6px 16px rgba(255, 107, 107, 0.4);
        }
    }

    /* Original Price (Struck Through) */
    .original-price {
        color: #999;
        font-size: 1.2rem;
        text-decoration: line-through;
        font-weight: 400;
        margin-bottom: 5px;
    }

    /* Discounted Price Display */
    .product-price[style*="dc3545"] {
        font-size: 2.5rem;
        font-weight: bold;
        color: #dc3545;
        margin-bottom: 10px;
    }

    /* Savings Info Box */
    .savings-info {
        display: inline-block;
        background: #d4edda;
        color: #155724;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        border: 1px solid #c3e6cb;
        animation: slideInUp 0.5s ease-out;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .savings-info svg {
        width: 16px;
        height: 16px;
        display: inline-block;
        vertical-align: middle;
        margin-right: 5px;
    }

    /* Discount Timer Box */
    .discount-timer {
        margin-top: 12px;
        padding: 10px;
        background: #fff3cd;
        border: 1px solid #ffc107;
        border-radius: 8px;
        color: #856404;
    }

    .discount-timer svg {
        width: 16px;
        height: 16px;
        display: inline-block;
        vertical-align: middle;
        margin-right: 5px;
    }

    .discount-timer strong {
        font-weight: 700;
    }

    /* Regular Price (No Discount) */
    .product-price {
        font-size: 2rem;
        font-weight: bold;
        color: #212529;
    }

    /* Tablet Responsive */
    @media (max-width: 992px) {
        .discount-badge {
            padding: 5px 10px;
            font-size: 13px;
        }

        .original-price {
            font-size: 1.1rem;
        }

        .product-price[style*="dc3545"] {
            font-size: 2.2rem;
        }

        .savings-info {
            padding: 7px 14px;
            font-size: 13px;
        }

        .discount-timer {
            padding: 9px;
            font-size: 13px;
        }
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .product-price-section {
            margin: 15px 0;
        }

        .discount-badge {
            padding: 5px 10px;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .original-price {
            font-size: 1rem;
            margin-bottom: 4px;
        }

        .product-price {
            font-size: 2rem !important;
        }

        .product-price[style*="dc3545"] {
            font-size: 2rem !important;
        }

        .savings-info {
            padding: 6px 12px;
            font-size: 12px;
        }

        .savings-info svg {
            width: 14px;
            height: 14px;
        }

        .discount-timer {
            padding: 8px;
            font-size: 12px;
            margin-top: 10px;
        }

        .discount-timer svg {
            width: 14px;
            height: 14px;
        }
    }

    /* Small Mobile Responsive */
    @media (max-width: 576px) {
        .discount-badge {
            padding: 4px 8px;
            font-size: 11px;
        }

        .original-price {
            font-size: 0.9rem;
        }

        .product-price {
            font-size: 1.75rem !important;
        }

        .product-price[style*="dc3545"] {
            font-size: 1.75rem !important;
        }

        .savings-info {
            padding: 5px 10px;
            font-size: 11px;
        }

        .discount-timer {
            padding: 7px;
            font-size: 11px;
        }
    }

    /* Very Small Mobile */
    @media (max-width: 400px) {
        .discount-badge {
            padding: 3px 7px;
            font-size: 10px;
        }

        .original-price {
            font-size: 0.85rem;
        }

        .product-price {
            font-size: 1.5rem !important;
        }

        .product-price[style*="dc3545"] {
            font-size: 1.5rem !important;
        }

        .savings-info {
            padding: 4px 8px;
            font-size: 10px;
        }

        .discount-timer {
            padding: 6px;
            font-size: 10px;
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

<div class="product-detail-container">
    <div class="container">
        <!-- Main Product Detail -->
        <div class="product-detail-card">
            <div class="product-main">
                <!-- Product Images -->
                <div class="product-images">
                    <div class="main-image">
                        @if (isset($product) && $product instanceof \App\Models\Product && $product->images->isNotEmpty())
                        <img id="mainProductImage"
                            src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                            alt="{{ $product->name }}">
                        @else
                        <img id="mainProductImage" src="{{ asset('images/no-image.png') }}" alt="No Image">
                        @endif
                    </div>

                    @if ($product->images && $product->images->count() > 1)
                    <!-- Slideshow Thumbnail Container -->
                    <div class="thumbnail-slideshow {{ $product->images->count() <= 4 ? 'no-navigation' : '' }}">
                        <div class="thumbnail-container" id="thumbnailContainer">
                            @foreach ($product->images as $index => $image)
                            <div class="thumbnail {{ $index == 0 ? 'active' : '' }}"
                                data-index="{{ $index }}"
                                onclick="changeMainImage('{{ asset('storage/' . $image->image_path) }}', this, {{ $index }})">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image {{ $index + 1 }}">
                            </div>
                            @endforeach
                        </div>

                        <!-- Navigation Controls -->
                        @if ($product->images->count() > 4)
                        <div class="slideshow-nav">
                            <button class="nav-button" id="prevBtn" onclick="previousSlide()">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="15,18 9,12 15,6"></polyline>
                                </svg>
                            </button>

                            <div class="slideshow-dots" id="slideshowDots">
                                <!-- Dots will be generated by JavaScript -->
                            </div>

                            <button class="nav-button" id="nextBtn" onclick="nextSlide()">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9,18 15,12 9,6"></polyline>
                                </svg>
                            </button>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="product-info" data-product-id="{{ $product->id }}">
                    <h1 class="product-title">{{ $product->name }}</h1>

                    @if ($product->deskripsi_singkat)
                    <p class="product-description">{{ $product->deskripsi_singkat }}</p>
                    @endif

                    <!-- Dynamic Rating Display - FIXED -->
                    <div class="product-rating">
                        <div class="stars">
                            @php
                            // Get average rating and round it
                            $averageRating = (float) $reviewStats['average_rating'];
                            $roundedRating = round($averageRating);
                            @endphp

                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <=$roundedRating)
                                <!-- Filled star (yellow) -->
                                <svg class="star" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2">
                                    <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26" />
                                </svg>
                                @else
                                <!-- Empty star (outline only) -->
                                <svg class="star" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26" />
                                </svg>
                                @endif
                                @endfor
                        </div>
                        <span class="rating-text">{{ $reviewStats['total_reviews'] }} reviews</span>
                    </div>

                    <!-- Price -->
                    <div class="product-price-section" style="margin: 20px 0;">
                        @if($product->hasActiveDiscount() || $product->is_on_sale)
                        <!-- Discount Badge -->
                        @if($product->hasActiveDiscount())
                        <div class="discount-badge" style="display: inline-block; background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%); color: white; padding: 6px 12px; border-radius: 8px; font-size: 14px; font-weight: 700; margin-bottom: 12px; box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);">
                            {{ $product->getDiscountLabel() }} OFF
                        </div>
                        @endif

                        <!-- Original Price (struck through) -->
                        <div class="original-price" style="color: #999; font-size: 1.2rem; text-decoration: line-through; font-weight: 400; margin-bottom: 5px;">
                            IDR {{ number_format($product->getOriginalPrice(), 0, ',', '.') }}
                        </div>

                        <!-- Discounted Price (large, red) -->
                        <div class="product-price" style="font-size: 2.5rem; font-weight: bold; color: #dc3545; margin-bottom: 10px;">
                            IDR {{ number_format($product->final_price, 0, ',', '.') }}
                        </div>

                        <!-- Savings Amount -->
                        @if($product->hasActiveDiscount())
                        <div class="savings-info" style="display: inline-block; background: #d4edda; color: #155724; padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; border: 1px solid #c3e6cb;">
                            <svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 5px;" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                            </svg>
                            You save IDR {{ number_format($product->getDiscountAmount(), 0, ',', '.') }}
                        </div>
                        @endif

                        <!-- Discount Timer (if discount has end date) -->
                        <x-discount-timer :product="$product" />
                        @else
                        <!-- Regular Price -->
                        <div class="product-price" style="font-size: 2rem; font-weight: bold; color: #212529;">
                            IDR {{ number_format($product->final_price, 0, ',', '.') }}
                        </div>
                        @endif
                    </div>

                    <!-- Color Selection -->
                    <div class="color-section">
                        <label class="section-label">Color: <span id="selectedColor">Black</span></label>
                        <div class="color-options">
                            <div class="color-option active" style="background-color: #000000" data-color="Black"
                                onclick="selectColor(this, 'Black')"></div>
                            <div class="color-option" style="background-color: #ffffff; border: 2px solid #e9ecef;"
                                data-color="White" onclick="selectColor(this, 'White')"></div>
                            <div class="color-option" style="background-color: #6c757d" data-color="Gray"
                                onclick="selectColor(this, 'Gray')"></div>
                        </div>
                    </div>

                    <!-- Size Selection -->
                    <div class="size-section">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <label class="section-label">Size</label>
                            <span class="size-guide">Size guides</span>
                        </div>
                        <div class="size-options">
                            @php
                            $sizes = ['S', 'M', 'L', 'XL'];
                            @endphp
                            @foreach ($sizes as $size)
                            <div class="size-option {{ $size === 'M' ? 'active' : '' }}"
                                data-size="{{ $size }}" onclick="selectSize(this, '{{ $size }}')">
                                {{ $size }}
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Stock Info -->
                    @if($product->stock_kuantitas <= 10 && $product->stock_kuantitas > 0)
                        <div class="stock-warning" style="color: #dc3545; font-size: 14px; font-weight: 500;">
                            Stok tinggal {{ $product->stock_kuantitas }} item
                        </div>
                        @elseif($product->stock_kuantitas <= 0)
                            <div class="stock-warning" style="color: #dc3545; font-size: 14px; font-weight: 500;">
                            Stok habis
                </div>
                @endif

                <!-- Actions -->
                <div class="product-actions">
                    <button class="add-to-cart-btn" onclick="addToCart()" {{ $product->stock_kuantitas <= 0 ? 'disabled' : '' }}>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            style="width: 20px; height: 20px;">
                            <circle cx="8" cy="21" r="1"></circle>
                            <circle cx="19" cy="21" r="1"></circle>
                            <path d="m2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                        </svg>
                        {{ $product->stock_kuantitas <= 0 ? 'Stok Habis' : 'Add to Cart' }}
                    </button>

                    <!-- Buy Now Button -->
                    <button class="buy-now-btn" onclick="buyNow()" {{ $product->stock_kuantitas <= 0 ? 'disabled' : '' }}>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            style="width: 20px; height: 20px;">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        {{ $product->stock_kuantitas <= 0 ? 'Stok Habis' : 'Buy Now' }}
                    </button>
                </div>

                <!-- Delivery Info -->
                <div class="delivery-info">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 3h5v5M4 20L21 3m0 16v-5h-5M8 20l-5-5" />
                    </svg>
                    Free delivery on orders over IDR 300,000
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-section">
        <h3 class="section-title">Customer Reviews</h3>

        <!-- Review Summary with Dynamic Data -->
        <div class="review-summary">
            <div class="review-summary-left">
                <div class="overall-rating">
                    <span class="rating-number">{{ $reviewStats['average_rating'] }}</span>

                    <!-- FIXED: Large Stars Display -->
                    <div class="rating-stars-large">
                        @php
                        $averageRating = (float) $reviewStats['average_rating'];
                        $roundedRating = round($averageRating);
                        @endphp

                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <=$roundedRating)
                            <!-- Filled star -->
                            <svg class="star-large" viewBox="0 0 24 24"
                                fill="currentColor"
                                stroke="currentColor" stroke-width="2">
                                <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26" />
                            </svg>
                            @else
                            <!-- Empty star -->
                            <svg class="star-large" viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor" stroke-width="2">
                                <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26" />
                            </svg>
                            @endif
                            @endfor
                    </div>

                    <p class="review-count">Based on {{ $reviewStats['total_reviews'] }} reviews</p>
                </div>
            </div>

            <div class="review-summary-right">
                <!-- Rating Distribution with Dynamic Data -->
                <div class="rating-distribution">
                    @for ($rating = 5; $rating >= 1; $rating--)
                    @php
                    $count = $reviewStats['rating_distribution'][$rating] ?? 0;
                    $percentage = $reviewStats['total_reviews'] > 0 ? ($count / $reviewStats['total_reviews']) * 100 : 0;
                    @endphp
                    <div class="rating-row">
                        <span class="rating-label">{{ $rating }} star</span>
                        <div class="rating-bar">
                            <div class="rating-fill" style="width: {{ $percentage }}%"></div>
                        </div>
                        <span class="rating-count-small">{{ $count }}</span>
                    </div>
                    @endfor
                </div>

                <!-- Recommendation Rate -->
                @if($reviewStats['total_reviews'] > 0)
                <div class="recommendation-rate">
                    <span class="recommendation-percentage">{{ $reviewStats['recommendation_percentage'] }}%</span>
                    <span class="recommendation-text">of customers recommend this product</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Reviews List with Censored Names -->
        @if($reviews->count() > 0)
        <div class="reviews-list">
            @foreach($reviews as $review)
            <div class="review-item">
                <div class="review-header">
                    <div class="reviewer-info">
                        <div class="reviewer-avatar">
                            {{ $review->reviewer_initials }}
                        </div>
                        <div class="reviewer-details">
                            <h4 class="reviewer-name">{{ $review->censored_name }}</h4>
                            <div class="review-meta">
                                <!-- Individual Review Stars - FIXED to show exact rating -->
                                <div class="review-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <=$review->rating)
                                        <!-- Filled star -->
                                        <svg class="star-small" viewBox="0 0 24 24"
                                            fill="currentColor"
                                            stroke="currentColor" stroke-width="2">
                                            <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26" />
                                        </svg>
                                        @else
                                        <!-- Empty star -->
                                        <svg class="star-small" viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26" />
                                        </svg>
                                        @endif
                                        @endfor
                                </div>
                                <span class="review-date">{{ $review->created_at->format('M d, Y') }}</span>
                                @if($review->is_verified)
                                <span class="verified-badge">Verified Purchase</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($review->is_recommended)
                    <div class="recommended-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                        </svg>
                        Recommended
                    </div>
                    @endif
                </div>

                @if($review->review)
                <div class="review-content">
                    <p>{{ $review->review }}</p>
                </div>
                @endif

                <!-- Review Images -->
                @if($review->images && count($review->images) > 0)
                <div class="review-images">
                    @foreach($review->images as $image)
                    <div class="review-image" onclick="openImageModal('{{ asset('storage/' . $image) }}')">
                        <img src="{{ asset('storage/' . $image) }}" alt="Review Image">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($reviews->hasPages())
        <div class="reviews-pagination" style="margin-top: 30px; display: flex; justify-content: center;">
            {{ $reviews->links() }}
        </div>
        @endif
        @else
        <div class="no-reviews">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 12l2 2 4-4M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <h4>No reviews yet</h4>
            <p>Be the first to review this product!</p>
        </div>
        @endif
    </div>

    <!-- Related Products -->
    @if (isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="related-section">
        <h3 class="section-title">You might also like</h3>
        <div class="related-products">
            @foreach ($relatedProducts as $relatedProduct)
            <a href="{{ route('products.show', $relatedProduct->slug) }}" class="related-product">
                <div class="related-image">
                    @if ($relatedProduct->images && $relatedProduct->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $relatedProduct->images->first()->image_path) }}"
                        alt="{{ $relatedProduct->name }}">
                    @else
                    <img src="{{ asset('images/no-image.png') }}" alt="No Image">
                    @endif
                </div>
                <div class="related-info">
                    <h4 class="related-name">{{ $relatedProduct->name }}</h4>
                    <p class="related-price">IDR
                        {{ number_format($relatedProduct->harga_jual ?? $relatedProduct->harga, 0, ',', '.') }}
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
</div>

<!-- Image Modal -->
<div class="image-modal" id="imageModal" onclick="closeImageModal()">
    <img id="modalImage" src="" alt="Review Image">
</div>

<script>
    // ============================================
    // GLOBAL VARIABLES
    // ============================================
    let selectedColor = 'Black';
    let selectedSize = 'M';
    const productId = {{ $product->id }};
    const isAuthenticated = {{ Auth::check() ? 'true' : 'false' }};
    const loginUrl = "{{ route('login') }}";
    const cartAddUrl = "{{ route('cart.add') }}";
    const checkoutUrl = "{{ route('checkout.index') }}";
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                      '{{ csrf_token() }}';

    // ============================================
    // INITIALIZE
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        console.log('✓ Page loaded');
        console.log('✓ Product ID:', productId);
        console.log('✓ Authenticated:', isAuthenticated);
        console.log('✓ CSRF Token:', csrfToken ? 'Found' : 'Missing');
        
        // Test if buttons exist
        const addToCartBtn = document.querySelector('.add-to-cart-btn');
        const buyNowBtn = document.querySelector('.buy-now-btn');
        console.log('✓ Add to Cart Button:', addToCartBtn ? 'Found' : 'Missing');
        console.log('✓ Buy Now Button:', buyNowBtn ? 'Found' : 'Missing');
    });

    // ============================================
    // COLOR SELECTION
    // ============================================
    function selectColor(element, color) {
        document.querySelectorAll('.color-option').forEach(option => {
            option.classList.remove('active');
        });
        element.classList.add('active');
        document.getElementById('selectedColor').textContent = color;
        selectedColor = color;
        console.log('Color selected:', color);
    }

    // ============================================
    // SIZE SELECTION
    // ============================================
    function selectSize(element, size) {
        document.querySelectorAll('.size-option').forEach(option => {
            option.classList.remove('active');
        });
        element.classList.add('active');
        selectedSize = size;
        console.log('Size selected:', size);
    }

    // ============================================
    // ADD TO CART FUNCTION
    // ============================================
    function addToCart() {
        console.log('🛒 Add to Cart clicked');

        // Check authentication
        if (!isAuthenticated) {
            showNotification('error', 'Silakan login terlebih dahulu');
            setTimeout(() => window.location.href = loginUrl, 1500);
            return;
        }

        // Validate CSRF token
        if (!csrfToken) {
            showNotification('error', 'Security token missing. Please refresh.');
            return;
        }

        const button = document.querySelector('.add-to-cart-btn');
        if (!button) {
            console.error('❌ Button not found');
            return;
        }

        // Disable button with loading state
        const originalHTML = button.innerHTML;
        button.disabled = true;
        button.innerHTML = `
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                 style="width: 20px; height: 20px; animation: spin 1s linear infinite;">
                <circle cx="12" cy="12" r="10"></circle>
            </svg>
            Adding...
        `;

        // Prepare request data
        const requestData = {
            product_id: productId,
            kuantitas: 1,
            color: selectedColor,
            size: selectedSize
        };

        console.log('📤 Sending request:', requestData);

        // Send AJAX request
        fetch(cartAddUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => {
            console.log('📥 Response status:', response.status);
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Request failed');
                });
            }
            return response.json();
        })
        .then(result => {
            console.log('✅ Success:', result);
            
            if (result.success) {
                showNotification('success', result.message || 'Produk ditambahkan ke keranjang');
                
                // Update cart count
                if (result.cart_count !== undefined) {
                    updateCartCount(result.cart_count);
                }
            } else {
                showNotification('error', result.message || 'Gagal menambahkan produk');
            }
        })
        .catch(error => {
            console.error('❌ Error:', error);
            showNotification('error', 'Terjadi kesalahan: ' + error.message);
        })
        .finally(() => {
            // Restore button
            button.disabled = false;
            button.innerHTML = originalHTML;
        });
    }

    // ============================================
    // BUY NOW FUNCTION - FIXED VERSION
    // ============================================
    function buyNow() {
        console.log('⚡ Buy Now clicked');

        // Check authentication
        if (!isAuthenticated) {
            showNotification('error', 'Silakan login terlebih dahulu');
            setTimeout(() => window.location.href = loginUrl, 1500);
            return;
        }

        // Validate CSRF token
        if (!csrfToken) {
            showNotification('error', 'Security token missing. Please refresh.');
            return;
        }

        const button = document.querySelector('.buy-now-btn');
        if (!button) {
            console.error('❌ Button not found');
            return;
        }

        // Disable button with loading state
        const originalHTML = button.innerHTML;
        button.disabled = true;
        button.innerHTML = `
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                 style="width: 20px; height: 20px; animation: spin 1s linear infinite;">
                <circle cx="12" cy="12" r="10"></circle>
            </svg>
            Processing...
        `;

        // Prepare request data
        const requestData = {
            product_id: productId,
            kuantitas: 1,
            color: selectedColor,
            size: selectedSize
        };

        console.log('📤 Sending request:', requestData);

        // Add to cart first
        fetch(cartAddUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => {
            console.log('📥 Response status:', response.status);
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Request failed');
                });
            }
            return response.json();
        })
        .then(result => {
            console.log('✅ Success:', result);
            
            if (result.success && result.cart_item && result.cart_item.id) {
                showNotification('success', 'Mengarahkan ke checkout...');
                
                // 🔥 FIX: Redirect to checkout with ONLY this cart item ID
                setTimeout(() => {
                    const checkoutUrlWithItem = checkoutUrl + '?items=' + result.cart_item.id;
                    console.log('🔗 Redirecting to:', checkoutUrlWithItem);
                    window.location.href = checkoutUrlWithItem;
                }, 1000);
            } else {
                showNotification('error', result.message || 'Gagal menambahkan produk');
                button.disabled = false;
                button.innerHTML = originalHTML;
            }
        })
        .catch(error => {
            console.error('❌ Error:', error);
            showNotification('error', 'Terjadi kesalahan: ' + error.message);
            button.disabled = false;
            button.innerHTML = originalHTML;
        });
    }

    // ============================================
    // NOTIFICATION SYSTEM
    // ============================================
    function showNotification(type, message) {
        // Remove existing notifications
        document.querySelectorAll('.custom-notification').forEach(n => n.remove());

        const notification = document.createElement('div');
        notification.className = `custom-notification custom-notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 80px;
            right: 20px;
            padding: 16px 24px;
            border-radius: 12px;
            color: white;
            z-index: 999999;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            transform: translateX(400px);
            transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            max-width: 400px;
            display: flex;
            align-items: center;
            gap: 10px;
            ${type === 'success' ? 
                'background: linear-gradient(135deg, #28a745 0%, #20c997 100%);' : 
                'background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);'
            }
        `;

        // Add icon
        const icon = type === 'success' ? 
            '<svg viewBox="0 0 24 24" fill="currentColor" style="width: 20px; height: 20px; flex-shrink: 0;"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>' :
            '<svg viewBox="0 0 24 24" fill="currentColor" style="width: 20px; height: 20px; flex-shrink: 0;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>';
        
        notification.innerHTML = icon + '<span>' + message + '</span>';
        document.body.appendChild(notification);

        // Slide in
        setTimeout(() => notification.style.transform = 'translateX(0)', 100);

        // Slide out and remove
        setTimeout(() => {
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => notification.remove(), 400);
        }, 3500);
    }

    // ============================================
    // UPDATE CART COUNT
    // ============================================
    function updateCartCount(count) {
        console.log('🔄 Updating cart count to:', count);
        
        const selectors = [
            '.cart-count',
            '#cart-count',
            '.navbar-cart-count',
            '[data-cart-count]',
            '.cart-badge'
        ];

        selectors.forEach(selector => {
            document.querySelectorAll(selector).forEach(element => {
                element.textContent = count;
                element.style.transition = 'transform 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
                element.style.transform = 'scale(1.4)';
                
                setTimeout(() => {
                    element.style.transform = 'scale(1)';
                }, 300);
            });
        });
    }

    // ============================================
    // IMAGE FUNCTIONS
    // ============================================
    function changeMainImage(imageSrc, thumbnailElement, index) {
        const mainImage = document.getElementById('mainProductImage');
        if (mainImage) {
            mainImage.style.opacity = '0.5';
            setTimeout(() => {
                mainImage.src = imageSrc;
                mainImage.style.opacity = '1';
            }, 200);
        }

        // Update active thumbnail
        document.querySelectorAll('.thumbnail').forEach(thumb => {
            thumb.classList.remove('active');
        });
        if (thumbnailElement) {
            thumbnailElement.classList.add('active');
        }
    }

    function openImageModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        if (modal && modalImage) {
            modalImage.src = imageSrc;
            modal.classList.add('active');
        }
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        if (modal) {
            modal.classList.remove('active');
        }
    }

    // ============================================
    // THUMBNAIL SLIDESHOW (if more than 4 images)
    // ============================================
    let currentSlide = 0;
    const thumbnailsPerView = 4;

    function updateSlideshow() {
        const container = document.getElementById('thumbnailContainer');
        const thumbnails = document.querySelectorAll('.thumbnail');
        const totalSlides = Math.ceil(thumbnails.length / thumbnailsPerView);
        
        if (!container || thumbnails.length <= thumbnailsPerView) return;

        const slideWidth = 100 / thumbnailsPerView;
        const offset = -(currentSlide * slideWidth * thumbnailsPerView);
        container.style.transform = `translateX(${offset}%)`;

        // Update dots
        const dotsContainer = document.getElementById('slideshowDots');
        if (dotsContainer) {
            dotsContainer.innerHTML = '';
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.createElement('div');
                dot.className = `dot ${i === currentSlide ? 'active' : ''}`;
                dot.onclick = () => goToSlide(i);
                dotsContainer.appendChild(dot);
            }
        }

        // Update button states
        document.getElementById('prevBtn').disabled = currentSlide === 0;
        document.getElementById('nextBtn').disabled = currentSlide === totalSlides - 1;
    }

    function nextSlide() {
        const thumbnails = document.querySelectorAll('.thumbnail');
        const totalSlides = Math.ceil(thumbnails.length / thumbnailsPerView);
        if (currentSlide < totalSlides - 1) {
            currentSlide++;
            updateSlideshow();
        }
    }

    function previousSlide() {
        if (currentSlide > 0) {
            currentSlide--;
            updateSlideshow();
        }
    }

    function goToSlide(index) {
        currentSlide = index;
        updateSlideshow();
    }

    // Initialize slideshow on load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', updateSlideshow);
    } else {
        updateSlideshow();
    }

    // ============================================
    // ADD SPIN ANIMATION
    // ============================================
    const style = document.createElement('style');
    style.textContent = `
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
</script>
@endsection