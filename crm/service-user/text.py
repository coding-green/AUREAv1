# Continuing with the remaining data

expanded_data_part2 = {
    "Category": [
        "Cleansers", "Cleansers", "Cleansers", "Cleansers", "Cleansers", 
        "Exfoliators", "Exfoliators", "Exfoliators", "Moisturizers", "Moisturizers",
        "Moisturizers", "Moisturizers", "Moisturizers", "Serums", "Serums", 
        "Serums", "Serums", "Serums", "Sunscreens", "Sunscreens", "Sunscreens", 
        "Sunscreens", "Sunscreens", "Toners", "Toners", "Toners", "Toners", "Toners"
    ],
    "Product": [
        "Glossier Milky Jelly Cleanser", "iS Clinical Cleansing Complex", "Alba Botanica Hawaiian Facial Scrub", 
        "Herbivore Botanicals Blue Tansy Resurfacing Clarity Mask", "Dermalogica Daily Microfoliant", 
        "Aveeno Positively Radiant Daily Moisturizer SPF 30", "Glow Recipe Watermelon Glow Pink Juice Moisturizer", 
        "Dr. Jart+ Ceramidin Cream", "Weleda Skin Food", "Embryolisse Lait-Crème Concentré", 
        "Lancome Advanced Génifique Youth Activating Serum", "Shani Darden Retinol Reform", 
        "Versed Stroke of Brilliance Brightening Serum", "StriVectin Super C Retinol Serum", 
        "Ole Henriksen Truth Serum", "Black Girl Sunscreen SPF 30", "Shiseido Ultimate Sun Protector Lotion SPF 50+", 
        "Tizo3 Mineral Sunscreen SPF 40", "Sun Bum Original SPF 50 Sunscreen Lotion", 
        "Alba Botanica Sensitive Mineral Sunscreen SPF 30", "Heritage Store Rosewater & Glycerin Facial Toner", 
        "Caudalie Vinopure Purifying Toner", "Eucerin Hydrating Toner", "Biologique Recherche P50", 
        "Mamonde Rose Water Toner", "Garnier SkinActive Gentle Sulfate-Free Cleanser", 
        "DHC Deep Cleansing Oil", "Vanicream Gentle Facial Cleanser"
    ],
    "Skin Type": [
        "Sensitive", "All Skin Types", "Oily/Acne-Prone", "All Skin Types", "All Skin Types", 
        "Normal/Dry", "All Skin Types", "Dry/Sensitive", "Dry", "All Skin Types", 
        "Mature", "All Skin Types", "Sensitive", "Mature", "All Skin Types", 
        "Oily/Acne-Prone", "Normal/Dry", "All Skin Types", "Oily/Normal", "All Skin Types", 
        "Sensitive", "All Skin Types", "Dry/Normal", "All Skin Types", "Dry", 
        "All Skin Types", "Oily", "All Skin Types"
    ],
    "Brand": [
        "Glossier", "iS Clinical", "Alba Botanica", "Herbivore Botanicals", "Dermalogica", 
        "Aveeno", "Glow Recipe", "Dr. Jart+", "Weleda", "Embryolisse", 
        "Lancome", "Shani Darden", "Versed", "StriVectin", "Ole Henriksen", 
        "Black Girl Sunscreen", "Shiseido", "Tizo", "Sun Bum", "Alba Botanica", 
        "Heritage Store", "Caudalie", "Eucerin", "Biologique Recherche", "Mamonde", 
        "Garnier", "DHC", "Vanicream"
    ]
}

# Creating DataFrame for the new products
df_part2 = pd.DataFrame(expanded_data_part2)

# Appending this data to the first part
df_combined = pd.concat([df_corrected, df_part2], ignore_index=True)

# Saving the updated data with more products to an Excel file
file_path_updated = '/mnt/data/skincare_products_100_us_based.xlsx'
df_combined.to_excel(file_path_updated, index=False)

file_path_updated
