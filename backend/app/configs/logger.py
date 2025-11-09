import structlog
import logging
import uuid

# logging.basicConfig(level=logging.INFO)

# structlog.configure(
#     processors=[
#         structlog.processors.add_log_level,
#         structlog.processors.TimeStamper(fmt="iso"),
#         structlog.processors.EventRenamer("message"),
#         structlog.processors.JSONRenderer(),
#     ]
# )

def get_logger(correlation_id):
    correlation_id = correlation_id or str(uuid.uuid4())
    logger = structlog.get_logger().bind(correlation_id=correlation_id)
    return logger