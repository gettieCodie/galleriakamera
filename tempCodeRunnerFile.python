estname = input ("Enter establishment name: ")
loc = input ("Enter location: ")
insname = input ("Enter inspector name: ")
date = input ("Enter inspector date (dd-mm-yyyy):")

print("\n= = = = = = = = = = = = = = = = = = = = = = = = = = = = =")
print("   SANITATION COMPLIANCE CHECKER FOR BARANGAY EATERIES")
print("= = = = = = = = = = = = = = = = = = = = = = = = = = = = =\n")

def establishment_details():
    print("I. ESTABLISHMENT DETAILS")
    print("_________________________________________________________")
    print(f"Establishment Name\t:{estname}")
    print(f"Barangay/Location \t:{loc}")
    print(f"Inspector Name    \t:{insname}")
    print(f"date of Inspection\t:{date}")

    return estname, loc, insname, date

test_menu = {
    1: "Food Handling",
    2: "Facility Cleanliness",
    3: "Water Supply",
    4: "Comfort room",
    5: "Drainage System",
    6: "Waste management"
}

completed_tests = set()


def menu_system(completed_tests):
    print(">>> SANITATION COMPLIANCE MENU <<<")
    print("[1] Food Handling\n[2] Facility Cleanliness\n[3] Water Supply\n[4] Comfort Room\n[5] Drainage System\n[6] Waste Management")

    num = int(input("\nHow many tests would you like to perform? "))
    print("Choose a number between 1 and 6.")

    selections = []

    for i in range(1, num + 1):
        while True:
            choice = int(input(f"Test {i}: "))
            if choice == 0:
                break
            elif choice in range(1, 7) and choice not in completed_tests:
                completed_tests.add(choice)
                selections.append(choice)
                break
            print("Invalid or already tested. Try again.")

    return selections

establishment_details()


chosen_tests = menu_system(completed_tests)

print("You selected:", chosen_tests)
