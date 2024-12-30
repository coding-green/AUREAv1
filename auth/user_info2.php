<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .form-container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group textarea {
            resize: vertical;
        }
        .form-group .note {
            font-size: 0.9em;
            color: #666;
        }
        .form-actions {
            text-align: center;
        }
        .form-actions button {
            padding: 10px 20px;
            background-color: #ff5757;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }
        .form-actions button:hover {
            background-color: #e04e4e;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Create Your Profile</h1>
        <form id="signupForm">
            <fieldset>
                <legend>Personal Information</legend>
                <div class="form-group">
                    <label for="name">Name *</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="location">Location *</label>
                    <input type="text" id="location" name="location" required>
                </div>
                <div class="form-group">
                    <label for="age">Age *</label>
                    <input type="number" id="age" name="age" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender *</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </fieldset>

            <fieldset>
                <legend>Contact Information</legend>
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number *</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
            </fieldset>

            <fieldset>
                <legend>Skin Profile</legend>
                <div class="form-group">
                    <label for="skinType">Skin Type (Select up to 2) *</label>
                    <select id="skinType" name="skinType" multiple required>
                        <option value="dry">Dry</option>
                        <option value="oily">Oily</option>
                        <option value="combination">Combination</option>
                        <option value="normal">Normal</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="skinConcerns">Skin Concerns</label>
                    <select id="skinConcerns" name="skinConcerns" multiple>
                        <option value="maintenance">Protective Maintenance</option>
                        <option value="congestion">Signs of Congestion</option>
                        <option value="dryness">Dryness / Dehydration</option>
                        <option value="dullness">Dullness / Lackluster Tone</option>
                        <option value="aging">General Signs of Aging</option>
                        <option value="texture">Textural Irregularities</option>
                        <option value="tone">Uneven Skin Tone</option>
                        <option value="pigmentation">Pigmentation Changes</option>
                        <option value="redness">Redness or Rosacea</option>
                        <option value="pores">Enlarged Pores</option>
                        <option value="acne">Pimples or Acne</option>
                    </select>
                </div>
            </fieldset>

            <fieldset>
                <legend>Additional Information</legend>
                <div class="form-group">
                    <label for="allergies">Allergies (if any)</label>
                    <textarea id="allergies" name="allergies"></textarea>
                </div>
                <div class="form-group">
                    <label for="experience">Experience with Skincare Technologies *</label>
                    <select id="experience" name="experience" required>
                        <option value="">Select</option>
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="preferredTextures">Preferred Textures or Finishes</label>
                    <textarea id="preferredTextures" name="preferredTextures"></textarea>
                </div>
                <div class="form-group">
                    <label for="profilePhoto">Profile Photo</label>
                    <input type="file" id="profilePhoto" name="profilePhoto">
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit">Create Profile</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('signupForm').addEventListener('submit', function(event) {
            event.preventDefault();
            alert('Form submitted successfully!');
        });
    </script>
</body>
</html>
