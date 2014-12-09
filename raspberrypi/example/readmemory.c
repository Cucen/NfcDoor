#include "nfc.h"

#define  	NFC_DEMO_DEBUG 	1

void main(void)
{
	uint32_t versiondata;
	uint32_t id;
	uint8_t keys[10]={0XFF,0XFF,0XFF,0XFF,0XFF,0XFF};
	uint8_t blockn;
	uint8_t i;

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
	printf("%x\n",((versiondata>>8) & 0xFF));
	printf("Supports ");
	printf("%x\n",(versiondata & 0xFF));
#endif
	// configure board to read RFID tags and cards
	i = SAMConfig();
	printf("SAMConfig is %d\n",i);

	while(1)
	{
		id = readPassiveTargetID(PN532_MIFARE_ISO14443A);
//		printf("the id is %d\n",id);

		if (id != 0)
		{
	#ifdef NFC_DEMO_DEBUG
			printf("Read card # %d",id);
	#endif

//		keys[]= {0xFF,0xFF,0xFF,0xFF,0xFF,0xFF};// default key of a fresh card
		for(blockn=0;blockn<64;blockn++)
		{
			if(authenticateBlock(1, id ,blockn,KEY_A,keys)) //authenticate block blockn
			{
				//if authentication successful
				uint8_t block[16];
				//read memory block blockn
				if(readMemoryBlock(1,blockn,block))
				{
				#ifdef NFC_DEMO_DEBUG
					//if read operation is successful
					for(i=0;i<16;i++)
					{
						//print memory block
						printf("%x",block[i]);
						if(block[i] <= 0xF) //Data arrangement / beautify
						{
							printf("  ");
						}
						else
						{
							printf(" ");
						}
					}
					printf("| Block ");

					if(blockn <= 9) //Data arrangement / beautify
					{
						printf(" ");
					}

					printf("%d",blockn);
					printf(" | ");

					if(blockn == 0)
					{
						printf("Manufacturer Block\n");
					}
					else
					{
						if(((blockn + 1) % 4) == 0)
						{
							printf("Sector Trailer\n");
						}
						else
						{
							printf("Data Block\n");
						}
					}
				#endif
				}
			}
		}
		}
		delay(2000);
	}
}



