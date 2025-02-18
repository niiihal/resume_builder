document.getElementById("job-category").addEventListener("change", function () {
    const category = this.value;
    const cvFields = document.getElementById("cv-fields");
    cvFields.innerHTML = ""; // Clear previous fields

    const fields = {
        common: [
            { label: "Full Name", type: "text", name: "name", placeholder: "Enter your full name" },
            { label: "Email", type: "email", name: "email", placeholder: "Enter your email" },
            { label: "Phone", type: "text", name: "phone", placeholder: "Enter your phone number" }
        ],
        teacher: [
            { label: "Subjects Taught", type: "text", name: "subjects", placeholder: "E.g., Math, Science" },
            { label: "Teaching Experience", type: "textarea", name: "experience", placeholder: "Describe your teaching experience" }
        ],
        programmer: [
            { label: "Programming Languages", type: "text", name: "languages", placeholder: "E.g., Python, JavaScript" },
            { label: "Projects", type: "textarea", name: "projects", placeholder: "Describe your projects" }
        ],
        officer: [
            { label: "Office Management Skills", type: "text", name: "skills", placeholder: "E.g., Leadership, Organization" },
            { label: "Work Experience", type: "textarea", name: "experience", placeholder: "Describe your experience" }
        ],
        govt: [
            { label: "Government Position", type: "text", name: "position", placeholder: "E.g., Clerk, Officer" },
            { label: "Years of Service", type: "text", name: "years", placeholder: "E.g., 5 years" }
        ],
        marketing: [
            { label: "Marketing Skills", type: "text", name: "skills", placeholder: "E.g., Digital Marketing, SEO" },
            { label: "Campaigns Handled", type: "textarea", name: "campaigns", placeholder: "Describe your marketing campaigns" }
        ],
        designing: [
            { label: "Design Software", type: "text", name: "software", placeholder: "E.g., Photoshop, Figma" },
            { label: "Portfolio Link", type: "text", name: "portfolio", placeholder: "Enter your portfolio link" }
        ],
        accounting: [
            { label: "Accounting Software", type: "text", name: "software", placeholder: "E.g., QuickBooks, Tally" },
            { label: "Years of Experience", type: "text", name: "years", placeholder: "E.g., 3 years" }
        ]
    };

    // Add common fields
    fields.common.forEach(field => createInputField(field));

    // Add category-specific fields
    if (category && fields[category]) {
        fields[category].forEach(field => createInputField(field));
    }
});

// Function to create input fields
function createInputField(field) {
    const fieldDiv = document.createElement("div");
    fieldDiv.classList.add("input-group");

    const label = document.createElement("label");
    label.innerText = field.label;

    let input;
    if (field.type === "textarea") {
        input = document.createElement("textarea");
    } else {
        input = document.createElement("input");
        input.type = field.type;
    }

    input.name = field.name;
    input.placeholder = field.placeholder;
    fieldDiv.appendChild(label);
    fieldDiv.appendChild(input);

    document.getElementById("cv-fields").appendChild(fieldDiv);
}

// Form Submission Alert
document.getElementById("cv-form").addEventListener("submit", function (event) {
    event.preventDefault();
    alert("Your customized CV has been generated successfully!");
});
