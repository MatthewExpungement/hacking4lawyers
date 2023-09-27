import requests
from time import sleep
from bs4 import BeautifulSoup


def scrape_page(base_url, id_value):
    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0"
    }
    url = f"{base_url}?ID={id_value}"
    response = requests.get(url, headers=headers)

    
    if response.status_code == 200:
        # Add your scraping logic here
        # For demonstration, we're just printing the first 500 characters of the HTML content
        soup = BeautifulSoup(response.text, 'html.parser')
        
        # Find the input fields by their IDs
        ids_to_search = ["first_name", "last_name", "email"]
        values = {}

        for id_str in ids_to_search:
            input_field = soup.find('input', {'id': id_str})
            
            if input_field:
                # Extract and store the value from the input field
                value = input_field.get('value', '')
                values[id_str] = value

        if values:
            print(f"Extracted values for ID {id_value}: {values}")
        else:
            print(f"No input fields found for ID {id_value}.")
    else:
        print(f"Failed to retrieve page with ID: {id_value}")

if __name__ == "__main__":
    base_url = "http://hacking4lawyers.com/blog/event.php"

    start_id = 1
    end_id = 10  # Feel free to change this to any number

    for id_value in range(start_id, end_id + 1):
        print(f"Scraping page with ID: {id_value}")
        scrape_page(base_url, id_value)
        sleep(1)  # Sleep for 2 seconds between requests to be polite to the web server