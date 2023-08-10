# Builder

## What is the problem?
Let's imagine, we have different classes that does the same job with a minor difference, in our example these classes are related to storage.  
As you know we can store our data by multiple ways like ram, file, database etc.

In our case, we have 2 classes which are storing data, and the only difference is that what will our connection be like. 

## Solution
1. Create StorageBuilder interface
2. Create classes that are implementing StorageBuilder interface
3. Create Director class
4. Add some methods to director class like **buildCacheStorage**, **buildQueueStorage**, **setBuilder**
5. And use it however you like