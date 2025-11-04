#!/bin/bash

echo "🚀 JazzCash ngrok Setup Script"
echo "================================"
echo ""

# Check if ngrok is installed
if ! command -v ngrok &> /dev/null; then
    echo "❌ ngrok is not installed. Please install it first:"
    echo "   brew install ngrok/ngrok/ngrok"
    exit 1
fi

echo "✅ ngrok is installed"
echo ""

# Check if authtoken is configured
if ! ngrok config check &> /dev/null; then
    echo "🔑 Please get your authtoken from: https://dashboard.ngrok.com/get-started/your-authtoken"
    echo ""
    read -p "Enter your ngrok authtoken: " authtoken
    
    if [ -z "$authtoken" ]; then
        echo "❌ No authtoken provided. Exiting."
        exit 1
    fi
    
    ngrok config add-authtoken "$authtoken"
    echo "✅ Authtoken configured"
else
    echo "✅ ngrok is already configured"
fi

echo ""
echo "🌐 Starting ngrok tunnel..."
echo "Your public URL will be displayed below:"
echo ""

# Start ngrok
ngrok http 8000
