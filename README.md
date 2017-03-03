# lyon-news-syndication
A WordPress plugin for consuming REST API.

## Data Storage

### Stored in the context of the instance (CPT?)
1. API constants
2. Last Edit (if not available anywhere else)
3. Last edit's user ID (if not available anywhere else)
4. Date/time of latest post matching criteria
5. category (multiples?)
6. total records
7. thumbnail size

### Optional
- Categories\*
- Total categories
- Tags\*
- Total tags

\*Pull all from API and count them:
- If greater or less than than saved total, regenerate list. 
- If equal to compare to array with the IDs. 
- If the same, use what is saved. 
- If different, regenerate list.

### Stored in Transient
1. HTML string
 1. Full markup of currently served content
 2. NOTE: The name of the transient is per configuration, and has to be named as such to avoid collisions.

## Logic

### On page load

1. GET DATE of latest post
    1. DATE matches saved DATE in stored instance configuration
        1. Transient exists
            1. Display transient
            2. END
        2. Transient does not exist
            1. GET new data that matches query from stored instance configuration
            2. PROCESS data based on stored configuration 
            3. SAVE to transient
            4. DISPLAY transient
            5. END
    2. Date *doesn’t* match database
        1. GET new data that matches query from stored instance configuration
        2. STORE date of latest post in instance configuration
        3. PROCESS data based on stored configuration 
        3. SAVE to transient
        4. DISPLAY transient
        5. END
