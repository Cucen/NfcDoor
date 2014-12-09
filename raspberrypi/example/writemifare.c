#include "nfc.h"

#define  NFC_DEMO_DEBUG 	1

uint8_t written = 0;

void main(void) 
{
	uint32_t versiondata;
	uint32_t id;
	uint8_t keys[10]= {0xFF,0xFF,0xFF,0xFF,0xFF,0xFF};
	uint8_t writeBuffer[16];
	uint8_t i;
	uint8_t block[16];

#ifdef NFC_DEMO_DEBUG
	printf("Hello!\n");
#endif
	begin();

	versiondata = getFirmwareVersion();
	if (! versiondata) 
	{
	#ifdef NFC_DEMO_DEBUG
		printf("Didn't find PN53x board\n");
	#endif
		while (1); // halt
	}
	
#ifdef NFC_DEMO_DEBUG
	// Got ok data, print it out!
	printf("Found chip PN5"); 
	printf("%x\n",((versiondata>>24) & 0xFF));
	printf("Firmware ver. "); 
	printf("%d",((versiondata>>16) & 0xFF));
	printf("."); 
	printf("%d\n",((versiondata>>8) & 0xFF));
	printf("Supports "); 
	printf("%x",(versiondata & 0xFF));
#endif
	// configure board to read RFID tags and cards
	SAMConfig();

	while(1)
	{
		// look for MiFare type cards
		id = readPassiveTargetID(PN532_MIFARE_ISO14443A);

		if (id != 0) 
		{
		#ifdef NFC_DEMO_DEBUG
			printf("Read card #%d\n",id);
		#endif

			for(i = 0;i < 16;i ++)
			{ 
				writeBuffer[i]=i; //Fill buffer with 0,1,2....F
			}
			if(authenticateBlock(1, id ,0x08,KEY_A,keys)) //authenticate block 0x08
			{
				//if authentication successful

				if(written == 0) //Not written
				{
					written = writeMemoryBlock(1,0x08,writeBuffer); // Write writeBuffer[] to block 0x08
					if(written)
					#ifdef NFC_DEMO_DEBUG
						printf("Write Successful\n");
					#endif
				}

				//read memory block 0x08
				if(readMemoryBlock(1,0x08,block))
				{
				#ifdef NFC_DEMO_DEBUG
					printf("Read block 0x08:"); 
					//if read operation is successful
					for(i=0;i<16;i++)
					{
						//print memory block
						printf("%x",block[i]);
						printf(" ");
					}
					printf("\n");
				#endif
				}
			}
		}
		delay(500);
	}
}


