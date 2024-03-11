package com.skillswapchat.app;


import java.time.LocalDateTime;

public class Message {
    private String userId;
    private LocalDateTime timestamp;
    private String content;

    public Message() {
    }

    public Message(String userId, LocalDateTime timestamp, String content) {
        this.userId = userId;
        this.timestamp = timestamp;
        this.content = content;
    }

    public String getUserId() {
        return userId;
    }

    public void setUserId(String userId) {
        this.userId= userId;
    }

    public LocalDateTime getTimestamp() {
        return timestamp;
    }

    public void setTimestamp(LocalDateTime timestamp) {
        this.timestamp= timestamp;
    }


    public String getContent() {
        return content;
    }

    public void setContent(String content) {
        this.content= content;
    }





}
