package com.skillswapchat.app;

import org.springframework.data.annotation.Id;
import org.springframework.data.mongodb.core.mapping.Document;

import java.util.List;

@Document(collection = "chat")
public class RoomChat {
    @Id
    private String roomId;
    private List<Message> messages;

    public RoomChat() {
    }

    public RoomChat(String roomId, List<Message> messages) {
        this.roomId = roomId;
        this.messages = messages;
    }

    public String getRoomId() {
        return roomId;
    }

    public void setRoomId(String roomId) {
        this.roomId = roomId;
    }

    public List<Message> getMessages() {
        return messages;
    }

    public void setMessages(List<Message> messages) {
        this.messages = messages;
    }




}
