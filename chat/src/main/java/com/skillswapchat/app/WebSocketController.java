package com.skillswapchat.app;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.messaging.handler.annotation.DestinationVariable;
import org.springframework.messaging.handler.annotation.MessageMapping;
import org.springframework.messaging.handler.annotation.Payload;
import org.springframework.messaging.handler.annotation.SendTo;
import org.springframework.stereotype.Controller;

import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.List;

import java.util.Comparator;

@Controller
public class WebSocketController {

    private final RoomChatRepository roomChatRepository;


    @Autowired
    public WebSocketController(RoomChatRepository roomChatRepository) {
        this.roomChatRepository = roomChatRepository;
    }

    @MessageMapping("/chat/{roomId}")
    @SendTo("/topic/messages/{roomId}")
    public Message sendMessage(@DestinationVariable("roomId") String roomId, @Payload Message message)
    {
        System.out.println("Message received: " + message.getContent());
        System.out.println("Message room: " + roomId);

        message.setTimestamp(LocalDateTime.now());

        RoomChat roomChat = getOrCreateChatRoom(roomId);
        List<Message> messages = roomChat.getMessages();

        if(messages == null)
        {
            messages = new ArrayList<>();
        }

        messages.add(message);
        roomChat.setMessages(messages);
        roomChat.setRoomId(roomId);
        roomChatRepository.save(roomChat);

        System.out.println("Message sent: " + message.getContent());

        return message;
    }



    @MessageMapping("/getPreviousMessages/{roomId}")
    @SendTo("/topic/messages/{roomId}")
    public List<Message> getPreviousMessages(@DestinationVariable("roomId") String roomId)
    {
        RoomChat roomChat = getOrCreateChatRoom(roomId);
        List<Message> messages = roomChat.getMessages();

        if(messages == null)
        {
            messages = new ArrayList<>();
        }

        System.out.println("Get previous messages for room: " + roomId);
        messages.forEach(message -> System.out.println(message.getContent()));

        return messages;
    }


    private RoomChat getOrCreateChatRoom(String roomId)
    {
        RoomChat roomChat = roomChatRepository.findById(roomId).orElse(null);
        if(roomChat == null)
        {
            roomChat = new RoomChat(roomId, null);
        }else{
            // Sort messages by timestamp
            List<Message> messages = roomChat.getMessages();
            messages.sort(Comparator.comparing(Message::getTimestamp));
        }
        return roomChat;
    }
}
