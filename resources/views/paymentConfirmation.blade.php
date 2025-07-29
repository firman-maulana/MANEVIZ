@extends('layouts.app2')

@section('content')

    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            margin-top: 40px
        }

        .header {
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-container {
            margin-top: 20px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
        }

        .form-group.full-width {
            flex: 2;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .required {
            color: #e74c3c;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid black;
            background: transparent;
            font-size: 14px;
            color: #333;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #333;
            background: white;
        }

        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid black;
            background: transparent;
            font-size: 14px;
            color: #333;
            appearance: none;
            background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAiIGhlaWdodD0iNiIgdmlld0JveD0iMCAwIDEwIDYiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxwYXRoIGQ9Ik05IDFMNSA1TDEgMSIgc3Ryb2tlPSIjMzMzIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K');
            background-repeat: no-repeat;
            background-position: right 15px center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            outline: none;
            border-color: #333;
            background-color: white;
        }

        .form-textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid black;
            background: transparent;
            font-size: 14px;
            color: #333;
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .form-textarea:focus {
            outline: none;
            border-color: black;
            background: white;
        }

        .submit-btn {
            background: #333;
            color: white;
            padding: 12px 24px;
            border: 2px solid #333;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .submit-btn:hover {
            background: #555;
            border-color: #555;
        }

        .submit-btn:active {
            transform: translateY(1px);
        }

        .input-with-prefix {
            display: flex;
            align-items: center;
            border: 1px solid black;
            background: transparent;
            transition: all 0.3s ease;
        }

        .input-with-prefix:focus-within {
            border-color: #333;
            background: white;
        }

        .input-with-prefix input {
            border: none;
            background: transparent;
            outline: none;
            padding: 12px 10px 12px 0;
            flex: 1;
            font-size: 14px;
            color: #333;
        }

        .input-prefix {
            padding: 12px 0 12px 15px;
            font-size: 14px;
            color: #666;
            font-weight: bold;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }
    </style>
     <div class="container">
        <div class="header">
            <h1 class="title">PAYMENT CONFIRMATION</h1>
        </div>

        <div class="success-message" id="success-message">
            Payment confirmation sent successfully! We will process your order shortly.
        </div>

        <div class="error-message" id="error-message">
            Please fill in all required fields correctly.
        </div>

        <div class="form-container">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="name">Name <span class="required">*</span></label>
                    <input type="text" id="name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" class="form-input" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="order-id">Order ID <span class="required">*</span></label>
                    <div class="input-with-prefix">
                        <span class="input-prefix">#</span>
                        <input type="text" id="order-id" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="total-transfer">Total Transfer <span class="required">*</span></label>
                    <div class="input-with-prefix">
                        <span class="input-prefix">Rp.</span>
                        <input type="text" id="total-transfer" required>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="transfer-to">Transfer To <span class="required">*</span></label>
                    <select id="transfer-to" class="form-select" required>
                        <option value="">Select Bank</option>
                        <option value="bca-449-008-1777">BCA 449-008-1777 a/n Anggullo Agrisbo</option>
                        <option value="mandiri">Mandiri</option>
                        <option value="bni">BNI</option>
                        <option value="bri">BRI</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="account-holder">Bank Account Holder <span class="required">*</span></label>
                    <input type="text" id="account-holder" class="form-input" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group full-width">
                    <label class="form-label" for="notes">Notes</label>
                    <textarea id="notes" class="form-textarea" placeholder="Add notes or special message..."></textarea>
                </div>
            </div>

            <button type="submit" class="submit-btn" onclick="submitForm()">Send</button>
        </div>
    </div>

    <script>
        function submitForm() {
            // Get form elements
            const nameField = document.getElementById('name');
            const emailField = document.getElementById('email');
            const orderIdField = document.getElementById('order-id');
            const totalTransferField = document.getElementById('total-transfer');
            const transferToField = document.getElementById('transfer-to');
            const accountHolderField = document.getElementById('account-holder');
            const notesField = document.getElementById('notes');

            // Hide previous messages
            document.getElementById('success-message').style.display = 'none';
            document.getElementById('error-message').style.display = 'none';

            // Basic validation
            const requiredFields = [nameField, emailField, orderIdField, totalTransferField, transferToField, accountHolderField];
            let isValid = true;

            // Reset border colors
            requiredFields.forEach(field => {
                if (field.parentElement.classList.contains('input-with-prefix')) {
                    field.parentElement.style.borderColor = '#ccc';
                } else {
                    field.style.borderColor = '#ccc';
                }
            });

            // Validate each field
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    if (field.parentElement.classList.contains('input-with-prefix')) {
                        field.parentElement.style.borderColor = '#e74c3c';
                    } else {
                        field.style.borderColor = '#e74c3c';
                    }
                    isValid = false;
                }
            });

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailField.value.trim() && !emailRegex.test(emailField.value)) {
                emailField.style.borderColor = '#e74c3c';
                isValid = false;
            }

            if (isValid) {
                // Show success message
                document.getElementById('success-message').style.display = 'block';
                
                // Reset form
                requiredFields.forEach(field => {
                    field.value = '';
                });
                notesField.value = '';

                // Scroll to top to show success message
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                // Show error message
                document.getElementById('error-message').style.display = 'block';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        // Add number formatting for total transfer
        document.addEventListener('DOMContentLoaded', function() {
            const totalTransferField = document.getElementById('total-transfer');
            
            totalTransferField.addEventListener('input', function(e) {
                // Remove non-numeric characters
                let value = this.value.replace(/[^0-9]/g, '');
                
                // Add thousand separators
                if (value) {
                    value = parseInt(value).toLocaleString('id-ID');
                }
                
                this.value = value;
            });

            // Prevent non-numeric input
            totalTransferField.addEventListener('keypress', function(e) {
                if (!/[0-9]/.test(e.key) && !['Backspace', 'Delete', 'Tab', 'Enter'].includes(e.key)) {
                    e.preventDefault();
                }
            });
        });
    </script>

@endsection