from selenium import webdriver
import time
import random
from selenium.webdriver.common.action_chains import ActionChains
from selenium.common.exceptions import NoSuchElementException
from selenium.common.exceptions import ElementClickInterceptedException
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import Select

    
#Duration in Seconds
def frontPage(duration, driver):
    driver.get("https://juedischtogo.de/")
    print("Showing Front Page for {} seconds".format(duration))

    #Starting with front Page
    rArrow = driver.find_element(By.CSS_SELECTOR, '.arrow.right')
    lArrow = driver.find_element(By.CSS_SELECTOR, '.arrow.left')

    post_in_Gallery = driver.execute_script("return posts.length")

    #scroll's through the Gallery tow time
    f = duration / (post_in_Gallery * 2)

    i = 0
    right = True
    def click():
        if(right):
            rArrow.click()
        else:
            lArrow.click()

    while(i < duration/f):
        time.sleep(f)
        try:
            click()
        except ElementClickInterceptedException:
            right = not right
            click()
        i += 1

def scrollUpAndDown(duration, driver, link):
    driver.get(link)
    print("Showing the '{}' Page for {} seconds".format(link, duration))

    time.sleep(1)

    page_height = driver.execute_script("return document.body.scrollHeight")
    f = page_height / ((duration - 2) * 100)

    current_scroll_position = 0
    while current_scroll_position < page_height:
        current_scroll_position += f
        driver.execute_script("window.scrollTo(0, {});".format(current_scroll_position))
        time.sleep(0.01)

    time.sleep(1)

def map_page(duration, driver):
    driver.get("https://juedischtogo.de/map")
    print("Showing the Map for {} seconds".format(duration))

    #Set Map View to the Center of the Map
    city_selector =  Select(driver.find_element(By.CLASS_NAME, "citySelector"))
    city_selector.select_by_visible_text('Passau')
    driver.find_element(By.CLASS_NAME, "citySelectorButton").click()

    time.sleep(duration)






#======================Start================================

PW = '1612'

#Chrome: Options to Hide the Controlled by Banner
chrome_options = webdriver.ChromeOptions()
chrome_options.add_experimental_option("useAutomationExtension", False)
chrome_options.add_experimental_option("excludeSwitches",["enable-automation"])
prefs = {"profile.default_content_settings.geolocation" : "2","credentials_enable_service": False,
     "profile.password_manager_enabled": False}
chrome_options.add_experimental_option("prefs",prefs)

#Firefox: Option for Geolocation
firefox_options = webdriver.FirefoxOptions()
firefox_options.set_preference("geo.enabled", False)
#firefox_options.set_preference("geo.prompt.testing", True)
#firefox_options.set_preference("geo.prompt.testing.allow", False)

#Ask User what Driver he wants to use
print("Welchen Browser möchtest du verwenden?\n1: Chrome\n2: Firefox\n3: Safari")
inpu = input();

#Select Input and define Driver
if(inpu == "1"):
    driver = webdriver.Chrome(chrome_options)
elif(inpu == "2"):
    driver = webdriver.Firefox(firefox_options)
elif(inpu == "3"):
    driver = webdriver.Safari()
else:
    print("Error: '{}' is not a Valid Input".format(inpu))
    exit

#Front Page
driver.get("https://juedischtogo.de/")

#Check for password Protected
try:
    pwbox = driver.find_element(By.ID, "password_protected_pass")
    print("Website Password Protected, Entering Password")
    # click on the Password Field
    # Send Password
    pwbox.send_keys(PW)
    # Click Button to Send form
    driver.find_element(By.ID, "wp-submit").click()
    
except NoSuchElementException:
    print("No Password Protection detected, continuing")


#On website

#Enter Full Screen
driver.maximize_window()
driver.fullscreen_window()

#In this Loop different sites will be rotated ans shown

sites = [
    "https://juedischtogo.de/locations/hartl-hartmann",
    "https://juedischtogo.de/locations/bernheim",
    "https://juedischtogo.de/locations/juden-in-passau-im-mittelalter/",
    "https://juedischtogo.de/locations/wie-lebten-juden-in-passau-in-der-dp-gemeinde-1946-52/",
    ]


while(True):
    #Show Front Page
    frontPage(20, driver)

    #Show Map
    map_page(15, driver)

    #Choose 2 random Sites to Scroll down
    for s in range(2):
        nr = random.randint(0, len(sites) - 1)
        scrollUpAndDown(20, driver, sites[nr])
