from transformers import AutoModelForCausalLM, AutoModel, AutoTokenizer, Trainer, TrainingArguments
from flask import Flask, request, jsonify
#import tensorflow as tf
import json
import pandas as pd
import torch
import os


app = Flask(__name__)

def process_dataset(dataset_content, file_format):
    # Convert the dataset_content to DataFrame
    return pd.DataFrame(dataset_content)

def fine_tune_model(dataframe, learning_rate, batch_size, epochs):
    """
    Fine-tune a language model using the provided dataset and hyperparameters.
    """
    # 1. Load the pre-trained model and tokenizer from Hugging Face
    #model_name = "codellama/CodeLlama-7B-Python"  # Replace with the exact model
    #model_name = "EleutherAI/gpt-j-6B"
    model_name = "gpt2"  # oppure "distilgpt2" o "EleutherAI/gpt-neo-125M"
    #tokenizer = AutoTokenizer.from_pretrained(model_name, from_tf=True)
    #model = AutoModelForCausalLM.from_pretrained(model_name, from_tf=True)
    tokenizer = AutoTokenizer.from_pretrained(model_name)
    model = AutoModelForCausalLM.from_pretrained(model_name)
    #model = AutoModel.from_pretrained(model_name)

    tokenizer.pad_token = tokenizer.eos_token

    # 2. Tokenize the dataset
    def tokenize_function(examples):
        return tokenizer(examples["text"], truncation=True, padding="max_length", max_length=512)

    dataset = dataframe.to_dict(orient='records')
    tokenized_datasets = [{"input_ids": tokenize_function(example)["input_ids"]} for example in dataset]

    # Convert to PyTorch Dataset
    class Dataset(torch.utils.data.Dataset):
        def __init__(self, data):
            self.data = data

        def __len__(self):
            return len(self.data)

        def __getitem__(self, idx):
            return {
                "input_ids": torch.tensor(self.data[idx]["input_ids"]),
                "labels": torch.tensor(self.data[idx]["input_ids"]),
            }

    train_dataset = Dataset(tokenized_datasets)

    # 3. Define training arguments
    training_args = TrainingArguments(
        output_dir="./results",                  # Directory to save model
        per_device_train_batch_size=batch_size, # Batch size per GPU
        num_train_epochs=epochs,                 # Number of epochs
        learning_rate=learning_rate,             # Learning rate
        weight_decay=0.01,                       # Weight decay for regularization
        logging_dir='./logs',                    # Directory for logs
        logging_steps=10,                        # Log every 10 steps
        save_steps=100,                          # Save every 100 steps
        evaluation_strategy="steps",             # Evaluate every few steps
        save_total_limit=2,                      # Save only the 2 most recent checkpoints
        load_best_model_at_end=True,             # Load best model after training
    )

    # 4. Define the trainer
    trainer = Trainer(
        model=model,
        args=training_args,
        train_dataset=train_dataset,
        tokenizer=tokenizer
    )

    # 5. Fine-tune the model
    print(f"Starting fine-tuning with {epochs=}, {learning_rate=}, {batch_size=}")
    trainer.train()
    print("Fine-tuning completed.")

    # 6. Save the model after fine-tuning
    model_dir = "./results/fine-tuned-model"
    if not os.path.exists(model_dir):
        os.makedirs(model_dir)
    model.save_pretrained(model_dir)
    tokenizer.save_pretrained(model_dir)

    print(f"Model saved to {model_dir}")

@app.route('/fine-tune', methods=['POST'])
def fine_tune():
    try:
        # Extract JSON data from request
        data = request.json

        # Get the dataset and file format
        dataset_content = data.get('dataset_file')
        file_format = data.get('file_format')
        learning_rate = data.get('learning_rate')
        batch_size = data.get('batch_size')
        epochs = data.get('epochs')

        # Validate the dataset is in the correct format
        if not isinstance(dataset_content, list):
            raise ValueError("dataset_file must be a list of JSON objects")

        # Process the dataset
        dataframe = process_dataset(dataset_content, file_format)

        # Fine-tune the model
        fine_tune_model(dataframe, learning_rate, batch_size, epochs)

        return jsonify({"status": "success", "message": "Model fine-tuned successfully."}), 200

    except Exception as e:
        return jsonify({"status": "error", "message": str(e)}), 500

if __name__ == "__main__":
    app.run(debug=True)
