package com.skillswapchat.app;

import org.springframework.data.annotation.Id;
import org.springframework.data.mongodb.repository.MongoRepository;


public interface RoomChatRepository extends MongoRepository<RoomChat, String>{
}
