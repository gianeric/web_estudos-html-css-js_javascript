import json

class EventMapper:
    def __init__(self):
        pass

    def map_event_to_dto(self, event: dict):
        body_str = event.get("body", "{}")
        try:
            body = json.loads(body_str)
        except json.JSONDecodeError:
            body = {}
        return body
