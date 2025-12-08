document.addEventListener("DOMContentLoaded", () => {
  const bubble = document.getElementById("chat-bubble");
  const chatWindow = document.getElementById("chat-window");
  const topWindow = document.getElementById("top-chat-window");
  const topIcon = document.getElementById("bot-icon-top");
  const messagesEl = document.getElementById("chat-messages");
  const input = document.getElementById("user-input");
  const sendBtn = document.getElementById("send-btn");
  const faqButtons = document.querySelectorAll(".faq-btn");
  const faqSection = document.getElementById("faq-buttons");
  const backButton = document.getElementById("back_button");
  const subQuestionsDiv = document.getElementById("sub-questions");

  bubble.addEventListener("click", () => {
    chatWindow.classList.toggle("open");
  });


  function timeNow() {
    const d = new Date();
    return d.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });
  }

faqButtons.forEach(btn => {
  btn.addEventListener("click", () => {
    const category = btn.dataset.category;
    const data = faqData[category];

    faqSection.style.display = "none";
    subQuestionsDiv.style.display = "flex";
    subQuestionsDiv.innerHTML = ""; 
     subQuestionsDiv.prepend(backButton);
      backButton.style.display="block";

     data.questions.forEach(q => {
      const qBtn = document.createElement("button");
      qBtn.className = "faq-btn";  
      qBtn.textContent = q;
      
      qBtn.addEventListener("click", () => {
        faqSection.style.display = "none";
        subQuestionsDiv.style.display = "none";
        backButton.style.display = "none";
        showAnswer(q, data.answers[q]);
     
      });

      subQuestionsDiv.appendChild(qBtn);
  
    });
  });
});


backButton.textContent = "←";
backButton.addEventListener("click", () => {
backButton.style.display="none";
subQuestionsDiv.style.display = "none"; 
faqSection.style.display="flex";


});


  function addMessage({ sender = "bot", text = "" }) {
    const wrapper = document.createElement("div");
    wrapper.classList.add("message", sender);
    const content = document.createElement("div");
    content.textContent = text;
    wrapper.appendChild(content);

    const meta = document.createElement("span");
    meta.className = "msg-meta";
    meta.textContent = timeNow();
    wrapper.appendChild(meta);

    messagesEl.appendChild(wrapper);
    messagesEl.prepend(backButton);
    backButton.style.display="block";
  }

  function showAnswer(question, answer) {
    addMessage({ sender: "user", text: question });
    addMessage({ sender: "bot", text: answer });
    
  }

  async function sendMessage() {
    faqSection.style.display = "none";
    subQuestionsDiv.style.display = "none";
    const text = input.value.trim();
    if (!text) return;

    addMessage({ sender: "user", text });
    input.value = "";

    const typing = document.createElement("div");
    typing.className = "message bot typing";
    typing.innerHTML =
      "<div class='msg-text'><span class='dot'></span><span class='dot'></span><span class='dot'></span></div>";
    messagesEl.appendChild(typing);

    try {
      const res = await fetch("http://localhost:5000/chat", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message: text }),
      });

      const data = await res.json();
      typing.remove();
      addMessage({ sender: "bot", text: data.reply });

    } catch (err) {
      typing.remove();
      addMessage({ sender: "bot", text: "⚠️ Sorry, I couldn’t connect to the AI." });
      console.error(err);
    }
  }
  sendBtn.addEventListener("click", () => {
    sendMessage();
    faqSection.style.display = "none";
  subQuestionsDiv.style.display = "none";
  });

  input.addEventListener("keydown", (e) => {
    if (e.key === "Enter") sendMessage();
    backButton.style.display = "block";
  });
});

const faqData = {
  account: {
    questions: [
      "How do I reset my password?",
      "Why is my account locked?",
      "Can I change my email?"
    ],
    answers: {
      "How do I reset my password?":
        "Go to the login page and click 'Forgot Password'. You’ll receive a reset link via email.",
      "Why is my account locked?":
        "Your account locks automatically after too many failed login attempts. It unlocks after 15 minutes.",
      "Can I change my email?":
        "Yes! Go to Settings → Account Info → Edit Email."
    }
  },

  courses: {
    questions: [
      "How do I enroll in a course?",
      "Can I drop or switch a course?"
    ],
    answers: {
      "How do I enroll in a course?":
        "Go to Courses → Enroll. Select your desired course and click 'Join'.",
      "Can I drop or switch a course?":
        "Yes, within the first two weeks. Go to Courses → Manage to update your enrollments."
    }
  },

  fees: {
    questions: [
      "How can I pay my tuition?",
      "Where do I download my receipts?"
    ],
    answers: {
      "How can I pay my tuition?":
        "You can pay using credit card, bank transfer, or mobile payment through the Billing page.",
      "Where do I download my receipts?":
        "Go to Billing → Payment History → Download Receipt."
    }
  }
};
