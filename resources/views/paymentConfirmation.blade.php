@extends('layouts.app2')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

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

        .submit-btn:disabled {
            background: #ccc;
            border-color: #ccc;
            cursor: not-allowed;
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

        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
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

        <form id="payment-confirmation-form" class="form-container">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="name">Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" class="form-input" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="order-id">Order ID <span class="required">*</span></label>
                    <div class="input-with-prefix">
                        <span class="input-prefix">#</span>
                        <input type="text" id="order-id" name="order_id" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="total-transfer">Total Transfer <span class="required">*</span></label>
                    <div class="input-with-prefix">
                        <span class="input-prefix">Rp.</span>
                        <input type="text" id="total-transfer" name="total_transfer" required>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="transfer-to">Transfer To <span class="required">*</span></label>
                    <select id="transfer-to" name="transfer_to" class="form-select" required>
                        <option value="">Select Bank</option>
                        <option value="bca-449-008-1777">BCA 449-008-1777 a/n Anggullo Agrisbo</option>
                        <option value="mandiri">Mandiri</option>
                        <option value="bni">BNI</option>
                        <option value="bri">BRI</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="account-holder">Bank Account Holder <span class="required">*</span></label>
                    <input type="text" id="account-holder" name="account_holder" class="form-input" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group full-width">
                    <label class="form-label" for="notes">Notes</label>
                    <textarea id="notes" name="notes" class="form-textarea" placeholder="Add notes or special message..."></textarea>
                </div>
            </div>

            <button type="submit" class="submit-btn" id="submit-btn">
                <span class="btn-text">Send</span>
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('payment-confirmation-form');
            const submitBtn = document.getElementById('submit-btn');
            const btnText = submitBtn.querySelector('.btn-text');
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');
            const totalTransferField = document.getElementById('total-transfer');

            // Format number input for total transfer
            totalTransferField.addEventListener('input', function(e) {
                let value = this.value.replace(/[^0-9]/g, '');
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

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                submitForm();
            });

            function submitForm() {
                // Hide previous messages
                successMessage.style.display = 'none';
                errorMessage.style.display = 'none';

                // Show loading state
                submitBtn.disabled = true;
                btnText.innerHTML = '<span class="spinner"></span>Sending...';
                form.classList.add('loading');

                // Prepare form data
                const formData = new FormData(form);

                // Convert total_transfer to number
                const totalTransfer = formData.get('total_transfer').replace(/[^0-9]/g, '');
                formData.set('total_transfer', totalTransfer);

                // Submit via AJAX
                fetch('{{ route("payment.confirmation.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        successMessage.style.display = 'block';
                        successMessage.textContent = data.message;

                        // Reset form
                        form.reset();

                        // Scroll to top
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    } else {
                        // Show error message
                        errorMessage.style.display = 'block';
                        errorMessage.textContent = data.message || 'Please fill in all required fields correctly.';

                        // Highlight invalid fields if errors provided
                        if (data.errors) {
                            highlightErrors(data.errors);
                        }

                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    errorMessage.style.display = 'block';
                    errorMessage.textContent = 'An error occurred while submitting the form. Please try again.';
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                })
                .finally(() => {
                    // Reset loading state
                    submitBtn.disabled = false;
                    btnText.innerHTML = 'Send';
                    form.classList.remove('loading');
                });
            }

            function highlightErrors(errors) {
                // Reset all field borders
                const allFields = form.querySelectorAll('.form-input, .form-select, .input-with-prefix');
                allFields.forEach(field => {
                    if (field.classList.contains('input-with-prefix')) {
                        field.style.borderColor = '#ccc';
                    } else {
                        field.style.borderColor = '#ccc';
                    }
                });

                // Highlight fields with errors
                Object.keys(errors).forEach(fieldName => {
                    const field = form.querySelector(`[name="${fieldName}"]`);
                    if (field) {
                        if (field.parentElement.classList.contains('input-with-prefix')) {
                            field.parentElement.style.borderColor = '#e74c3c';
                        } else {
                            field.style.borderColor = '#e74c3c';
                        }
                    }
                });
            }
        });
    </script>

@endsection