{{-- resources/views/partials/ai-chat-modal.blade.php --}}
<!-- AI Chat Modal -->
<div class="ai-chat-modal" id="aiChatModal">
    <div class="chat-modal-content">
        <div class="chat-header">
            <div class="chat-header-info">
                <div class="chat-avatar">
                    <i class="bi bi-robot"></i>
                </div>
                <div class="chat-title">
                    <h3>MANEVIZ Assistant</h3>
                    <p class="chat-status">
                        <span class="status-dot"></span>
                        Online - Siap membantu Anda
                    </p>
                </div>
            </div>
            <button class="chat-close-btn" onclick="closeChatModal()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="chat-messages" id="chatMessages">
            <div class="chat-message bot-message">
                <div class="message-avatar">
                    <i class="bi bi-robot"></i>
                </div>
                <div class="message-content">
                    <div class="message-bubble">
                        <p>Halo! 👋 Saya MANEVIZ Assistant. Ada yang bisa saya bantu hari ini?</p>
                        <span class="message-time">Baru saja</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="chat-typing-indicator" id="typingIndicator" style="display: none;">
            <div class="typing-dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <span class="typing-text">Assistant sedang mengetik...</span>
        </div>

        <div class="chat-input-container">
            <div class="quick-replies" id="quickReplies">
                <button class="quick-reply-btn" onclick="sendQuickReply('Produk apa saja yang tersedia?')">
                    🛍️ Lihat Produk
                </button>
                <button class="quick-reply-btn" onclick="sendQuickReply('Ada promo diskon?')">
                    🏷️ Info Promo
                </button>
                <button class="quick-reply-btn" onclick="sendQuickReply('Bagaimana cara order?')">
                    📦 Cara Order
                </button>
            </div>

            <div class="chat-input-wrapper">
                <input
                    type="text"
                    class="chat-input"
                    id="chatInput"
                    placeholder="Ketik pesan Anda..."
                    autocomplete="off"
                >
                <button class="chat-send-btn" id="chatSendBtn" onclick="sendMessage()">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Floating Chat Button -->
<button class="floating-chat-btn" id="floatingChatBtn" onclick="openChatModal()">
    <i class="bi bi-chat-dots-fill"></i>
    <span class="chat-notification-badge" id="chatNotificationBadge" style="display: none;">1</span>
</button>

<style>
/* AI Chat Modal Styles */
.ai-chat-modal {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 400px;
    max-width: calc(100vw - 40px);
    height: 600px;
    max-height: calc(100vh - 120px);
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    z-index: 2000;
    display: none;
    animation: slideUp 0.3s ease;
}

.ai-chat-modal.show {
    display: block;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.chat-modal-content {
    display: flex;
    flex-direction: column;
    height: 100%;
    border-radius: 20px;
    overflow: hidden;
}

.chat-header {
    background: #000000;
    color: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-header-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.chat-avatar {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.chat-title h3 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
}

.chat-status {
    margin: 2px 0 0;
    font-size: 0.85rem;
    opacity: 0.9;
    display: flex;
    align-items: center;
    gap: 6px;
}

.status-dot {
    width: 8px;
    height: 8px;
    background: #ffffff;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.chat-close-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.chat-close-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    background: #f8f9fa;
    scroll-behavior: smooth;
}

.chat-messages::-webkit-scrollbar {
    width: 6px;
}

.chat-messages::-webkit-scrollbar-track {
    background: transparent;
}

.chat-messages::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.chat-message {
    display: flex;
    gap: 10px;
    margin-bottom: 16px;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.bot-message {
    justify-content: flex-start;
}

.user-message {
    justify-content: flex-end;
}

.user-message .message-content {
    order: 1;
}

.message-avatar {
    width: 35px;
    height: 35px;
    background: #000000;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.user-message .message-avatar {
    background: #000000;
}

.message-content {
    max-width: 75%;
}

.message-bubble {
    background: white;
    padding: 12px 16px;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.user-message .message-bubble {
    background: #000000;
    color: white;
}

.message-bubble p {
    margin: 0;
    font-size: 0.95rem;
    line-height: 1.5;
    word-wrap: break-word;
}

.message-time {
    display: block;
    font-size: 0.75rem;
    color: #94a3b8;
    margin-top: 6px;
}

.user-message .message-time {
    color: rgba(255, 255, 255, 0.8);
}

.chat-typing-indicator {
    padding: 10px 20px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    gap: 10px;
}

.typing-dots {
    display: flex;
    gap: 4px;
}

.typing-dots span {
    width: 8px;
    height: 8px;
    background: #000000;
    border-radius: 50%;
    animation: typingDot 1.4s infinite;
}

.typing-dots span:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-dots span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typingDot {
    0%, 60%, 100% {
        transform: translateY(0);
    }
    30% {
        transform: translateY(-10px);
    }
}

.typing-text {
    font-size: 0.85rem;
    color: #64748b;
}

.chat-input-container {
    background: white;
    border-top: 1px solid #e2e8f0;
}

.quick-replies {
    padding: 12px 20px;
    display: flex;
    gap: 8px;
    overflow-x: auto;
    border-bottom: 1px solid #e2e8f0;
}

.quick-replies::-webkit-scrollbar {
    height: 4px;
}

.quick-replies::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.quick-reply-btn {
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    padding: 8px 14px;
    border-radius: 20px;
    font-size: 0.85rem;
    color: #475569;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.3s ease;
}

.quick-reply-btn:hover {
    background: #000000;
    border-color: #000000;
    color: white;
    transform: translateY(-2px);
}

.chat-input-wrapper {
    display: flex;
    gap: 10px;
    padding: 15px 20px;
    align-items: center;
}

.chat-input {
    flex: 1;
    border: 1px solid #e2e8f0;
    border-radius: 25px;
    padding: 12px 20px;
    font-size: 0.95rem;
    outline: none;
    transition: all 0.3s ease;
}

.chat-input:focus {
    border-color: #000000;
    box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
}

.chat-send-btn {
    background: #000000;
    border: none;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.chat-send-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
}

.chat-send-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: scale(1);
}

/* Floating Chat Button */
.floating-chat-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    background: #000000;
    border: none;
    border-radius: 50%;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
    z-index: 1999;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    margin-bottom: 30px;
    margin-right: 15px;
}

.floating-chat-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.5);
}

.chat-notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #000000;
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: bold;
    border: 2px solid white;
}

/* Product Card in Chat */
.product-card-chat {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 12px;
    margin-top: 10px;
    display: flex;
    gap: 12px;
    align-items: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.product-card-chat:hover {
    background: #e2e8f0;
    transform: translateX(5px);
}

.product-card-chat img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

.product-card-info {
    flex: 1;
}

.product-card-name {
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 4px;
    color: #1e293b;
}

.product-card-price {
    color: #000000;
    font-weight: 600;
    font-size: 0.95rem;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .ai-chat-modal {
        bottom: 0;
        right: 0;
        left: 0;
        width: 100%;
        max-width: 100%;
        height: 100vh;
        max-height: 100vh;
        border-radius: 0;
    }

    .chat-modal-content {
        border-radius: 0;
    }

    .floating-chat-btn {
        bottom: 15px;
        right: 15px;
        width: 55px;
        height: 55px;
        font-size: 1.3rem;
    }

    .quick-replies {
        padding: 10px 15px;
    }

    .message-content {
        max-width: 85%;
    }
}

@media (max-width: 480px) {
    .chat-header {
        padding: 15px;
    }

    .chat-avatar {
        width: 40px;
        height: 40px;
        font-size: 1.3rem;
    }

    .chat-title h3 {
        font-size: 1rem;
    }

    .chat-status {
        font-size: 0.8rem;
    }

    .chat-messages {
        padding: 15px;
    }

    .quick-reply-btn {
        font-size: 0.8rem;
        padding: 7px 12px;
    }
}
</style>

<script>
// AI Chat functionality
let chatHistory = [];

function openChatModal() {
    const modal = document.getElementById('aiChatModal');
    const floatingBtn = document.getElementById('floatingChatBtn');
    const badge = document.getElementById('chatNotificationBadge');

    modal.classList.add('show');
    floatingBtn.style.display = 'none';

    if (badge) {
        badge.style.display = 'none';
    }

    // Focus on input
    setTimeout(() => {
        document.getElementById('chatInput').focus();
    }, 300);
}

function closeChatModal() {
    const modal = document.getElementById('aiChatModal');
    const floatingBtn = document.getElementById('floatingChatBtn');

    modal.classList.remove('show');
    floatingBtn.style.display = 'flex';
}

function sendQuickReply(message) {
    document.getElementById('chatInput').value = message;
    sendMessage();
}

async function sendMessage() {
    const input = document.getElementById('chatInput');
    const message = input.value.trim();

    if (!message) return;

    // Add user message to chat
    addMessage(message, 'user');
    input.value = '';

    // Show typing indicator
    showTypingIndicator();

    try {
        const response = await fetch('/ai-chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ message: message })
        });

        const data = await response.json();

        // Hide typing indicator
        hideTypingIndicator();

        if (data.success) {
            addMessage(data.message, 'bot');
        } else {
            addMessage('Maaf, terjadi kesalahan. Silakan coba lagi.', 'bot');
        }
    } catch (error) {
        hideTypingIndicator();
        addMessage('Maaf, terjadi kesalahan koneksi. Silakan coba lagi.', 'bot');
        console.error('Chat error:', error);
    }
}

function addMessage(text, sender) {
    const messagesContainer = document.getElementById('chatMessages');
    const messageDiv = document.createElement('div');
    messageDiv.className = `chat-message ${sender}-message`;

    const time = new Date().toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit'
    });

    if (sender === 'user') {
        messageDiv.innerHTML = `
            <div class="message-content">
                <div class="message-bubble">
                    <p>${escapeHtml(text)}</p>
                    <span class="message-time">${time}</span>
                </div>
            </div>
            <div class="message-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
        `;
    } else {
        messageDiv.innerHTML = `
            <div class="message-avatar">
                <i class="bi bi-robot"></i>
            </div>
            <div class="message-content">
                <div class="message-bubble">
                    <p>${formatBotMessage(text)}</p>
                    <span class="message-time">${time}</span>
                </div>
            </div>
        `;
    }

    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;

    // Store in history
    chatHistory.push({ text, sender, time });
}

function formatBotMessage(text) {
    // Convert URLs to clickable links
    text = text.replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank" style="color: #000000; text-decoration: underline;">Lihat Produk</a>');

    // Convert line breaks
    text = text.replace(/\n/g, '<br>');

    return text;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function showTypingIndicator() {
    document.getElementById('typingIndicator').style.display = 'flex';
    const messagesContainer = document.getElementById('chatMessages');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function hideTypingIndicator() {
    document.getElementById('typingIndicator').style.display = 'none';
}

// Handle Enter key in chat input
document.addEventListener('DOMContentLoaded', function() {
    const chatInput = document.getElementById('chatInput');
    if (chatInput) {
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendMessage();
            }
        });
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeChatModal();
    }
});
</script>
