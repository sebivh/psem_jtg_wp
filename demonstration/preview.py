from selenium import webdriver
import time
import random
import math
from selenium.webdriver.common.action_chains import ActionChains
from selenium.common.exceptions import NoSuchElementException
from selenium.common.exceptions import ElementClickInterceptedException
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import Select
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

#=====================================================================================================

PW = '1612'

#======================================================================================================

sites = [
    "https://juedischtogo.de/locations/hartl-hartmann",
    "https://juedischtogo.de/locations/bernheim",
    "https://juedischtogo.de/locations/juden-in-passau-im-mittelalter/",
    "https://juedischtogo.de/locations/wie-lebten-juden-in-passau-in-der-dp-gemeinde-1946-52/",
    ]

videos = [
    "https://juedischtogo.de/wp-content/uploads/2023/02/VID-20230717-WA0022.mp4",
    "https://juedischtogo.de/wp-content/uploads/2023/07/Video-Gina-Roitman.mp4",
]

#======================================================================================================

def is_password_site(driver):
    try:
        driver.find_element(By.ID, "password_protected_pass")
        return True
    except NoSuchElementException:
        return False

def hasTag(driver, tag):
    #Check for password Protected
    try:
        audio = driver.find_element(By.TAG_NAME, tag)
        return True
    
    except NoSuchElementException:
        return False

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

def scrollUpAndDown(duration, driver, link, playMedia):
    driver.get(link)

    #If the Play Media Flag is set and the Page has an Audio Element play the Audio while scrolling, else continue
    if(playMedia & hasTag(driver, 'audio')):
        #Wait for Audio to load
        time.sleep(1)
        #Set new Duration
        duration = math.ceil(driver.execute_script("return document.querySelector('audio').duration"))
        #Interakt with Browser for Security
        driver.find_element(By.TAG_NAME, "body").click()

        #Play the Audio
        driver.execute_script("document.querySelector('audio').play()")
        print("Showing the '{}' Page with Media for {} seconds".format(link,  duration))
    else:
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

def play_video(driver, link):
    driver.get(link)

    #Wait for Video to load
    time.sleep(1)

    #Sets Duration
    duration = math.ceil(driver.execute_script("return document.querySelector('video').duration"))

    #Fullscreens the Video
    driver.execute_script("document.querySelector('video').requestFullscreen()")

    #Play
    driver.execute_script("document.querySelector('video').play()")

    print("Showing the '{}' Video for {} seconds".format(link, duration))

    time.sleep(duration)







#======================Start================================

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
inpuD = input()

#Ask User if Media should be played
print("Sollen die Medien auf der Website wiedergegeben werden? Wenn ja, versucht das Skript Audio Dateien auf den Seiten zu finden und diese Abzuspielen. Die Seiten werden dann auch so lange angezeigt solange die Audio spielt. Auch werden Videos zwischen den einzelnen Seiten abgespielt. \n1: Ja\n2: Nein")
inpuM = input()
#Set Flag
playMedia = (inpuM == '1')


#Ask User how many Pages should be shown after another
print("Wie viele Websites sollen hintereinander angezeigt werden?")
page_seq = input()
if(not page_seq):
    page_seq = 8
else:
    page_seq = int(page_seq)

#Ask User how long Pages should be shown
print("Wie viele Sekunden lang sollen ein Ort angezeigt werden?")
page_dur = input()
if(not page_dur):
    page_dur = 30
else:
    page_dur = int(page_dur)


if(playMedia):
    print("Medien Wiedergabe ist Aktiv: Wie viele Videos sollen hintereinander angezeigt werden?")
    video_seq = input()
    if(not video_seq):
        video_seq = 1
    else:
        video_seq = int(video_seq)


#Select Input and define Driver
if(inpuD == "1"):
    driver = webdriver.Chrome(chrome_options)
elif(inpuD == "2"):
    driver = webdriver.Firefox(firefox_options)
elif(inpuD == "3"):
    driver = webdriver.Safari()
else:
    print("Error: '{}' is not a Valid Input".format(inpu))
    exit

#Front Page
driver.get("https://juedischtogo.de/")

#Check for password Protected
if(is_password_site(driver)):
    pwbox = driver.find_element(By.ID, "password_protected_pass")
    print("Website Password Protected, Entering Password")
    # click on the Password Field
    # Send Password
    pwbox.send_keys(PW)
    # Click Button to Send form
    driver.find_element(By.ID, "wp-submit").click()
else:
    print("No Password Protection detected, continuing")


#On website

#Enter Full Screen
driver.maximize_window()
driver.fullscreen_window()

#In this Loop different sites will be rotated ans shown

while(True):

    #Show Front Page
    frontPage(page_dur, driver)

    #Show Map
    map_page(15, driver)

    #Choose 2 random Sites to Scroll down
    for s in range(page_seq):
        nr = random.randint(0, len(sites) - 1)
        scrollUpAndDown(page_dur, driver, sites[nr], playMedia)

    #Play one Random Video if the playMedia Flag is set
    if(playMedia):
        for s in range(video_seq):
            nr = random.randint(0, len(videos) - 1)
            play_video(driver, videos[nr])
