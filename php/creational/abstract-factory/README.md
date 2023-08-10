# Abstract Factory

## What is the problem?
Let's say, we are building a news fetcher system, and as you can imagine there are so many news sources, and we have 2 classes (Mapper, Client) for every news source.
Should we edit classes whenever we add a new news source? What about Open-Closed Prenciple? I dont think so, 
looks bad, doesn't it?
That's exactly why we have to find a solution.

## Solution
1. Create interfaces for mapper and client classes
2. Create Factory interface and define methods like **getMapper** and **getClient**
3. Create factory classes for every news source
4. Create a class with that accept constructor parameter as a factory interface
5. Send any factory class, then you ready to go.