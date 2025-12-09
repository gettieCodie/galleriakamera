import dotenv from "dotenv";
import { GoogleGenerativeAI } from "@google/generative-ai";

dotenv.config();

console.log("🔑 API Key:", process.env.GEMINI_API_KEY ? "Present" : "Missing");
console.log("Testing API key validity...");

try {
  const genAI = new GoogleGenerativeAI(process.env.GEMINI_API_KEY);
  const model = genAI.getGenerativeModel({ model: "gemini-2.5-flash" });
  
  console.log("⏳ Making test request...");
  const result = await model.generateContent("Say 'Hello' in one word");
  const response = await result.response;
  
  console.log("✅ API Key is VALID!");
  console.log("Response:", response.text());
} catch (err) {
  console.log("❌ API Key is INVALID or there's an error:");
  console.log("Error:", err.message);
  
  if (err.message.includes("API_KEY_INVALID")) {
    console.log("⚠️  Your API key is not valid. Please get a new one from https://aistudio.google.com/app/apikey");
  }
}
