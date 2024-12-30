<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paginated Skincare Profile Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;

            background-color: #f9f9f9;
        }
        form {
            min-width: 550px;
            min-height: fit-content;
            max-height: 500px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"], input[type="email"], input[type="number"], input[type="file"], select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            position: relative;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .page {
            display: none;
        }
        .page.active {
            display: block;
        }

        /* Error state styles */
        input:invalid, select:invalid, textarea:invalid {
            border: 1px solid red;
        }

        input:invalid::after, select:invalid::after, textarea:invalid::after {
            content: attr(data-error);
            position: absolute;
            color: red;
            font-size: 12px;
            bottom: -25px;
            left: 10px;
        }

        .tooltip {
            position: absolute;
            background-color: #f44336;
            color: white;
            padding: 5px;
            font-size: 12px;
            border-radius: 4px;
            top: -30px;
            left: 10px;
            display: none;
        }
        input:invalid + .tooltip, select:invalid + .tooltip, textarea:invalid + .tooltip {
            display: block;
        }
    </style>
    <script>
        let currentPage = 0;

        function showPage(pageIndex) {
            const pages = document.querySelectorAll('.page');
            pages.forEach((page, index) => {
                page.classList.toggle('active', index === pageIndex);
            });
        }

        function validatePage() {
            const currentInputs = document.querySelectorAll(`.page.active input, .page.active select, .page.active textarea`);
            let valid = true;

            currentInputs.forEach(input => {
                if (!input.checkValidity()) {
                    input.classList.add('invalid');
                    const errorMessage = `Please fill out the "${input.previousElementSibling.textContent}" field.`;
                    input.setAttribute('data-error', errorMessage);  // Set custom error message
                    valid = false;
                } else {
                    input.classList.remove('invalid');
                    input.removeAttribute('data-error');
                }
            });

            return valid;
        }

        function nextPage() {
            const pages = document.querySelectorAll('.page');
            if (validatePage() && currentPage < pages.length - 1) {
                currentPage++;
                showPage(currentPage);
            }
        }

        function prevPage() {
            if (currentPage > 0) {
                currentPage--;
                showPage(currentPage);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            showPage(currentPage);
        });
    </script>
</head>
<body>
    <form>
        <div class="page active">
            <h2>Personal Information</h2>
            <label for="name">Enter Name *</label>
            <input type="text" id="name" name="name" required>
            <div class="tooltip"></div>

            <label for="location">Location *</label>
            <input type="text" id="location" name="location" required>
            <div class="tooltip"></div>

            <label for="age">Enter Age *</label>
            <input type="number" id="age" name="age" required>
            <div class="tooltip"></div>

            <label for="gender">Enter Gender *</label>
            <select id="gender" name="gender" required>
                <option value="">Select</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            <div class="tooltip"></div>
            <button type="button" onclick="nextPage()">Next</button>
        </div>

        <div class="page">
            <h2>Contact Information</h2>
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" required>
            <div class="tooltip"></div>

            <label for="phone">Phone No. *</label>
            <input type="text" id="phone" name="phone" required>
            <div class="tooltip"></div>

            <button type="button" onclick="prevPage()">Previous</button>
            <button type="button" onclick="nextPage()">Next</button>
        </div>

        <div class="page">
            <h2>Skin Profile</h2>
            <label for="skin-type">Skin Type (Select up to 2) *</label>
            <select id="skin-type" name="skin-type" multiple required>
                <option value="dry">Dry</option>
                <option value="oily">Oily</option>
                <option value="combination">Combination</option>
                <option value="normal">Normal</option>
            </select>
            <div class="tooltip"></div>

            <label for="skin-concerns">Skin Concerns (Select all that apply):</label>
            <select id="skin-concerns" name="skin-concerns" multiple size="6">
                <option value="maintenance">Protective Maintenance</option>
                <option value="congestion">Signs of Congestion</option>
                <option value="dryness">Dryness / Dehydration</option>
                <option value="dullness">Dullness / Lackluster Tone</option>
                <option value="aging">General Signs of Aging</option>
                <option value="texture">Textural Irregularities</option>
                <option value="uneven">Uneven Skin Tone</option>
                <option value="pigmentation">Pigmentation Changes</option>
                <option value="redness">Redness or Rosacea</option>
                <option value="pores">Enlarged Pores</option>
                <option value="acne">Pimples or Acne</option>
            </select>
            <div class="tooltip"></div>

            <button type="button" onclick="prevPage()">Previous</button>
            <button type="button" onclick="nextPage()">Next</button>
        </div>

        <div class="page">
            <h2>Additional Information</h2>
            <label for="allergies">Allergies (if any):</label>
            <textarea id="allergies" name="allergies" rows="4"></textarea>

            <label for="experience">Experience with Skincare Technologies *</label>
            <select id="experience" name="experience" required>
                <option value="beginner">Beginner</option>
                <option value="intermediate">Intermediate</option>
                <option value="advanced">Advanced</option>
            </select>
            <div class="tooltip"></div>

            <label for="preferences">Preferred Textures or Finishes:</label>
            <textarea id="preferences" name="preferences" rows="4"></textarea>

            <label for="profile-photo">Profile Photo:</label>
            <input type="file" id="profile-photo" name="profile-photo">

            <button type="button" onclick="prevPage()">Previous</button>
            <button type="submit">Submit</button>
        </div>
    </form>
</body>
</html>
